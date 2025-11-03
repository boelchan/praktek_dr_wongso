<?php

namespace App\Livewire\Patient;

use App\Livewire\Traits\WithTableX;
use App\Models\Patient;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class PatientIndex extends Component
{
    use WithTableX;

    public $search_full_name;

    public $search_nik;

    public $search_address;

    public $search_no_rm;

    public function updateStatus($id, $status)
    {
        $data = Patient::findOrFail($id);
        $data->status = $status;
        $data->save();

        Toaster::success('Status berhasil diperbarui');
    }

    public function render()
    {
        $data = Patient::when($this->search_full_name, fn ($q) => $q->where('full_name', 'like', '%'.$this->search_full_name.'%'))
            ->when($this->search_nik, fn ($q) => $q->where('nik', 'like', '%'.$this->search_nik.'%'))
            ->when($this->search_no_rm, fn ($q) => $q->where('no_rm', 'like', '%'.$this->search_no_rm.'%'))
            ->when($this->search_address, fn ($q) => $q->where('address', 'like', '%'.$this->search_address.'%'));

        return view('livewire.patient.patient-index', [
            'data' => $this->applyTable($data),
        ]);
    }
}
