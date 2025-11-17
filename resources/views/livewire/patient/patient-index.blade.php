<x-layouts.content title="Pasien">

    <div>
        <x-table.filter :open="$open">
            <x-slot:action>
                <a href="{{ route('patient.create') }}" class="btn btn-soft btn-primary w-10 h-10 lg:w-auto">
                    <i class="ti ti-plus text-lg"></i> <span class="hidden lg:inline">Tambah</span>
                </a>
            </x-slot:action>

            <x-form.input label="No Rekam Medis" model="search_no_rm" floating live />
            <x-form.input label="NIK" model="search_nik" floating live />
            <x-form.input label="Nama" model="search_full_name" floating live />
            <x-form.input label="Alamat" model="search_address" floating live />

        </x-table.filter>

        <x-table :paginate="$data">
            <x-table.thead :sortField="$sortField" :sortDirection="$sortDirection">
                <x-table.th width="5%" />
                <x-table.th label="No RM" sort="no_rm" width="20%" />
                <x-table.th label="NIK" sort="nik" width="20%" />
                <x-table.th label="Nama" sort="full_name" width="20%" />
                <x-table.th label="Alamat" sort="address" width="20%" />
                <x-table.th label="Status" sort="status" width="10%" />
                <x-table.th />
            </x-table.thead>

            <tbody>
                @forelse ($data as $index => $d)
                    <x-table.tr>
                        <td class="p-2"> {{ $index + 1 }} </td>
                        <td class="p-2"> {{ $d->no_rm }} </td>
                        <td class="p-2"> {{ $d->nik }} </td>
                        <td class="p-2"> {{ $d->full_name }} ({{ $d->gender }})</td>
                        <td class="p-2"> {{ $d->address }} </td>
                        <td class="p-2">
                            @if ($d->status == 'active')
                                <div class="cursor-pointer badge badge-outline badge-success" wire:click="updateStatus({{ $d->id }}, 'non_active')" wire:confirm="Non Aktifkan Pasien ?">Aktif</div>
                            @else
                                <div class="cursor-pointer badge badge-outline badge-error" wire:click="updateStatus({{ $d->id }}, 'active')" wire:confirm="Aktifkan kembali ?">Non Aktif</div>
                            @endif
                        </td>
                        <td class="p-2 flex flex-2 gap-2 justify-end">
                            @if (count($d->encounter) == 0)
                                <div class="btn btn-xs btn-error btn-soft btn-square tooltip tooltip-left" data-tip="hapus" wire:click="delete({{ $d->id }})" wire:confirm="Hapus ?"><i class="ti ti-trash text-lg"></i></div>
                            @endif
                            @if ($d->status == 'active')
                                <a href="{{ route('patient.edit', $d->id) }}"class="btn btn-xs btn-success btn-soft btn-square tooltip tooltip-left" data-tip="edit"><i class="ti ti-pencil text-lg"></i></a>
                            @endif
                            <a href="{{ route('patient.show', $d->id) }}"class="btn btn-xs btn-info btn-soft btn-square tooltip tooltip-left" data-tip="detail pasien"><i class="ti ti-list text-lg"></i></a>
                        </td>
                    </x-table.tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-slate-500">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </x-table>
    </div>

</x-layouts.content>
