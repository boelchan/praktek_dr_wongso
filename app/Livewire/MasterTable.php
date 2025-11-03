<?php

namespace App\Livewire;

use App\Livewire\Traits\WithTableX;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class MasterTable extends Component
{
    use WithTableX;

    public $model;          // Nama class model

    public $columns = [];   // Kolom tabel (label)

    public $filters = [];   // Tipe filter

    public $filterValues = [];

    // Create
    public $showCreateModal = false;

    public $createData = [];

    // Edit
    public $showEditModal = false;

    public $editId;

    public $editData = [];

    public $fillable = [];

    public $fields = [];

    public $displayToSource = []; // contoh: ['category.name' => 'category_id']

    public function mount($model)
    {
        $this->model = $model;

        // Konversi semua Column ke array
        $this->fields = collect($model::formFields())
            ->mapWithKeys(function ($col) {
                if ($col instanceof \App\Support\Column) {
                    return [$col->field => $col->toArray()];
                }

                return [$col['field'] => $col];
            })
            ->toArray();

        foreach ($this->fields as $field => $meta) {
            $displayKey = $meta['show'] ?? $field;
            $this->columns[$displayKey] = $meta['label'];
            $this->displayToSource[$displayKey] = $field;

            if (! empty($meta['searchable'])) {
                $this->filters[$field] = $meta['type'] === 'select' ? 'select' : 'text';
                $this->filterValues[$field] = '';
            }
        }

        $this->fillable = (new $model)->getFillable();

        // ===== Default Sort =====
        $defaultSortField = collect($this->fields)
            ->filter(fn ($meta) => isset($meta['sort_default']))
            ->first();

        if ($defaultSortField) {
            $fieldName = $defaultSortField['show'] ?? $defaultSortField['field'];
            $this->sortField = $fieldName;
            $this->sortDirection = $defaultSortField['sort_default'];
        } else {
            // fallback ke kolom pertama yang sortable
            foreach ($this->fields as $field => $meta) {
                if (! empty($meta['sortable'])) {
                    $this->sortField = $meta['show'] ?? $field;
                    $this->sortDirection = 'asc';
                    break;
                }
            }
        }
    }

    public function resetFilters()
    {
        foreach ($this->filters as $field => $type) {
            $this->filterValues[$field] = '';
        }
        $this->resetPage();
    }

    public function updatedFilterValues()
    {
        $this->resetPage();
    }

    public function rules()
    {
        $rules = [];

        foreach ($this->fields as $field => $meta) {
            if (! empty($meta['rules'])) {
                $rules['createData.'.$field] = $meta['rules'];
                $rules['editData.'.$field] = $meta['rules'];
            }
        }

        return $rules;
    }

    public function closeModal($modal)
    {
        if ($modal === 'create') {
            $this->reset('createData', 'showCreateModal');
        }

        if ($modal === 'edit') {
            $this->reset('editData', 'editId', 'showEditModal');
        }

        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function store()
    {
        $rules = [];
        foreach ($this->fields as $field => $meta) {
            $rules["createData.$field"] = $meta['rules'] ?? 'nullable';
        }

        $validated = $this->validate($rules);

        $modelClass = $this->model;
        $modelClass::create($validated['createData']); // ✅ ambil bagian createData saja

        $this->reset('createData', 'showCreateModal');
        Toaster::success('Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $modelClass = $this->model;
        $data = $modelClass::findOrFail($id);

        $this->editId = $id;
        $this->editData = $data->toArray();
        $this->showEditModal = true;
    }

    public function update()
    {
        $rules = [];
        foreach ($this->fields as $field => $meta) {
            $rules["editData.$field"] = $meta['rules'] ?? 'nullable';
        }

        $validated = $this->validate($rules);

        $modelClass = $this->model;
        $modelClass::findOrFail($this->editId)->update($validated['editData']); // ✅

        $this->reset('editId', 'editData', 'showEditModal');
        Toaster::success('Data berhasil diperbarui');
    }

    public function delete($id)
    {
        $modelClass = $this->model;

        try {
            $data = $modelClass::findOrFail($id);
            $data->delete();

            Toaster::success('Data berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            Toaster::error('Data gagal dihapus karena masih digunakan di tabel lain');
        } catch (\Exception $e) {
            Toaster::error('Terjadi kesalahan saat menghapus data');
        }
    }

    public function render()
    {
        $modelClass = $this->model;
        $query = $modelClass::query();

        // dd($this->filterValues);
        foreach ($this->filterValues as $field => $value) {
            if ($value === '' || $value === null) {
                continue;
            }
            $meta = $this->fields[$field] ?? null;
            if (! $meta || empty($meta['searchable'])) {
                continue;
            }

            // kalau select → filter ke field aslinya (misalnya category_id)
            // dd($field  +'  '  + $value);
            if ($meta['type'] === 'select') {
                $query->where($field, $value);
            } else {
                // kalau text/number → cek apakah show mengandung relasi
                $displayKey = $meta['show'] ?? $field;

                if (str_contains($displayKey, '.')) {
                    [$relation, $column] = explode('.', $displayKey, 2);
                    $query->whereHas($relation, function ($q) use ($column, $value) {
                        $q->where($column, 'like', "%{$value}%");
                    });
                } else {
                    $query->where($field, 'like', "%{$value}%");
                }
            }
        }

        // Eager load relasi dari 'show'
        $relations = [];
        foreach ($this->fields as $field => $meta) {
            if (isset($meta['show']) && str_contains($meta['show'], '.')) {
                $relations[] = explode('.', $meta['show'])[0];
            }
        }
        if ($relations) {
            $query->with(array_unique($relations));
        }

        // ===== FIX SORTING UNTUK RELASI =====
        if ($this->sortField) {
            $displayKey = $this->sortField;                                 // contoh: 'category.name'
            $sourceKey = $this->displayToSource[$displayKey] ?? $displayKey; // contoh: 'category_id'
            $meta = $this->fields[$sourceKey] ?? null;

            if ($meta && ! empty($meta['sortable'])) {
                if (str_contains($displayKey, '.')) {
                    // Sort by kolom relasi: join lalu orderBy
                    [$relation, $column] = explode('.', $displayKey, 2);

                    $relationInstance = (new $modelClass)->$relation();
                    $relatedTable = $relationInstance->getRelated()->getTable();
                    $foreignKey = $relationInstance->getQualifiedForeignKeyName();
                    $ownerKey = $relationInstance->getQualifiedOwnerKeyName();

                    $query->leftJoin($relatedTable, $foreignKey, '=', $ownerKey)
                        ->orderBy($relatedTable.'.'.$column, $this->sortDirection)
                        ->select((new $modelClass)->getTable().'.*');
                } else {
                    // Sort by kolom biasa
                    $query->orderBy($displayKey, $this->sortDirection);
                }
            }
        }

        $data = $query->paginate($this->perPage)->onEachSide(1);

        return view('livewire.master-table', [
            'data' => $data,
            'fields' => $this->fields,
            'columns' => $this->columns,        // display key => label
            'displayToSource' => $this->displayToSource, // kirim ke Blade
        ]);
    }
}
