<x-layouts.content title="Kunjungan">

    <div>
        <x-table.filter :open="$open">
            <x-slot:action>
                <a href="{{ route('encounter.create') }}" class="btn btn-soft btn-primary w-10 h-10 lg:w-auto">
                    <i class="ti ti-plus text-lg"></i> <span class="hidden lg:inline">Tambah</span>
                </a>
            </x-slot:action>

            <x-form.input label="Tanggal" model="search_encounter_date" type="date" floating live />

        </x-table.filter>

        <x-table :paginate="$data">
            <x-table.thead :sortField="$sortField" :sortDirection="$sortDirection">
                <x-table.th width="5%" />
                <x-table.th label="Tanggal" sort="encounter_date" width="15%" />
                <x-table.th label="Pasien" width="30%" />
                <x-table.th label="Keluhan" width="40%" />
                <x-table.th />
            </x-table.thead>

            <tbody>
                @forelse ($data as $index => $d)
                    <x-table.tr>
                        <td class="p-2"> {{ $index + 1 }} </td>
                        <td class="p-2"> {{ $d->encounter_date }} </td>
                        <td class="p-2"> {{ $d->patient->full_name }} </td>
                        <td class="p-2"> {{ $d->keluhan_utama }} </td>
                        <td class="p-2 flex gap-2">
                            <a href="{{ route('encounter.edit', $d->id) }}"class="btn btn-xs btn-success btn-soft btn-square"><i class="ti ti-pencil text-lg"></i></a>
                            <div class="btn btn-xs btn-error btn-soft btn-square" wire:click="delete({{ $d->id }})" wire:confirm="Hapus ?"><i class="ti ti-trash text-lg"></i></div>
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
