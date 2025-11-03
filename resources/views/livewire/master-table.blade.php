<div>

    <x-table.filter :open="$open">

        <x-slot:action>
            <button wire:click="$set('showCreateModal', true)" class="btn btn-primary btn-soft w-10 h-10 lg:w-auto">
                <i class="ti ti-plus text-lg"></i> <span class="lg:inline hidden">Tambah</span>
            </button>
        </x-slot:action>

        {{-- field seach --}}
        @foreach ($fields as $field => $meta)
            @if (isset($meta['searchable']) and $meta['searchable'])
                @if ($meta['type'] === 'select')
                    <x-form.select label="{{ $meta['label'] }}" model="filterValues.{{ $field }}" :options="$meta['options']" floating live />
                @elseif(in_array($meta['type'], ['text', 'number', 'date']))
                    <x-form.input label="{{ $meta['label'] }}" model="filterValues.{{ $field }}" type="{{ $meta['type'] ?? 'text' }}" floating live />
                @endif
            @endif
        @endforeach

    </x-table.filter>

    <!-- Table -->
    <x-table :paginate="$data">
        <x-table.thead :sortField="$sortField" :sortDirection="$sortDirection">
            <x-table.th width="5%" />
            @foreach ($columns as $displayKey => $label)
                @php
                    // Map display key (bisa 'category.name') ke source key ('category_id')
                    $sourceKey = $displayToSource[$displayKey] ?? $displayKey;
                    $isSortable = !empty($fields[$sourceKey]['sortable']);
                @endphp

                @if ($isSortable)
                    <x-table.th :label="$label" :sort="$displayKey" />
                @else
                    <x-table.th :label="$label" />
                @endif
            @endforeach

            <x-table.th />
        </x-table.thead>

        <tbody>
            @forelse ($data as $d)
                <x-table.tr>
                    <td>{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</td>

                    @foreach ($columns as $field => $label)
                        @php
                            $meta = $fields[$field] ?? [];
                        @endphp

                        @if (($meta['type'] ?? null) === 'custom')
                            <td class="p-2">
                                @if (isset($meta['display']))
                                    {{-- render dari file blade --}}
                                    @include($meta['display'], ['row' => $d])
                                @elseif(isset($meta['raw']))
                                    {{-- render raw HTML, bisa akses $row juga --}}
                                    {!! str_replace(['{id}', '{name}'], [$d->id, $d->name], $meta['raw']) !!}
                                @endif
                            </td>
                        @else
                            <td class="p-2">{{ data_get($d, $field) }}</td>
                        @endif
                    @endforeach

                    <td class="p-2 flex gap-1">
                        <button class="btn btn-xs btn-warning btn-soft btn-square" wire:click="edit({{ $d->id }})">
                            <i class="ti ti-pencil text-lg"></i>
                        </button>
                        <button class="btn btn-soft btn-xs btn-error btn-square" wire:click="delete({{ $d->id }})" wire:confirm="Hapus ?">
                            <i class="ti ti-trash text-lg"></i>
                        </button>
                    </td>

                </x-table.tr>
            @empty
                <x-table.tr>
                    <td colspan="{{ count($columns) + 2 }}" class="text-center p-4 text-slate-500">
                        Tidak ada data
                    </td>
                </x-table.tr>
            @endforelse
        </tbody>
    </x-table>

    <!-- Modal Create -->
    <dialog id="createModal" class="modal" @if ($showCreateModal) open @endif>
        <div class="modal-box w-11/12 max-w-2xl">
            <form method="dialog">
                <button wire:click="closeModal('create')" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>

            <h3 class="mb-4 text-lg font-bold">Tambah Data</h3>

            <form wire:submit.prevent="store">
                @foreach ($fields as $field => $meta)
                    @if (($meta['type'] ?? null) !== 'custom')
                        @if ($meta['type'] === 'select')
                            <x-form.select label="{{ $meta['label'] }}" model="createData.{{ $field }}" :options="$meta['options']" />
                        @else
                            <x-form.input label="{{ $meta['label'] }}" model="createData.{{ $field }}" type="{{ $meta['type'] ?? 'text' }}" />
                        @endif
                    @endif
                @endforeach

                <div class="modal-action">
                    <button type="button" wire:click="closeModal('create')" class="btn btn-ghost">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </dialog>

    <!-- Modal Edit -->
    <dialog id="editModal" class="modal" @if ($showEditModal) open @endif>
        <div class="modal-box w-11/12 max-w-2xl">
            <form method="dialog">
                <button wire:click="closeModal('edit')" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>

            <h3 class="mb-4 text-lg font-bold">Edit Data</h3>

            <form wire:submit.prevent="update">
                @foreach ($fields as $field => $meta)
                    @if (($meta['type'] ?? null) !== 'custom')
                        @if ($meta['type'] === 'select')
                            <x-form.select label="{{ $meta['label'] }}" model="editData.{{ $field }}" :options="$meta['options']" />
                        @else
                            <x-form.input label="{{ $meta['label'] }}" model="editData.{{ $field }}" type="{{ $meta['type'] ?? 'text' }}" />
                        @endif
                    @endif
                @endforeach

                <div class="modal-action">
                    <button type="button" wire:click="closeModal('edit')" class="btn btn-ghost">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </dialog>
</div>
