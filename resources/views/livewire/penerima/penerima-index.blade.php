<x-layouts.content title="Penerima">

    <div>
        <x-table.filter :open="$open">
            <x-slot:action>
                <a href="{{ route('penerima.create') }}" wire:navigate class="btn btn-soft btn-primary w-10 h-10 lg:w-auto">
                    <i class="ti ti-plus text-lg"></i> <span class="hidden lg:inline">Tambah</span>
                </a>
            </x-slot:action>

            <x-form.input label="Nama" model="search_nama" floating live />
            <x-form.input label="No Rekening" model="search_nomor_rekening" floating live />
            <x-form.input label="Alamat" model="search_alamat" floating live />

        </x-table.filter>

        <x-table :paginate="$data">
            <x-table.thead :sortField="$sortField" :sortDirection="$sortDirection">
                <x-table.th width="3%" />
                <x-table.th label="Nama" sort="nama" />
                <x-table.th label="No Rekening" />
                <x-table.th label="Alamat" />
                <x-table.th label="Bulan lalu" />
                <x-table.th label="Bulan ini" />
                <x-table.th label="Tahun ini" />
                <x-table.th />
            </x-table.thead>

            <tbody>
                @forelse ($data as $index => $d)
                    <x-table.tr>
                        <td class="p-2"> {{ $index + 1 }} </td>
                        <td class="p-2"> {{ $d->nama }} </td>
                        <td class="p-2"> {{ $d->nomor_rekening }} </td>
                        <td class="p-2"> {{ $d->alamat }} </td>
                        <td class="p-2"> Rp {{ number_format($d->total_bulan_lalu, 0, ',', '.') }} </td>
                        <td class="p-2"> Rp {{ number_format($d->total_bulanan, 0, ',', '.') }} </td>
                        <td class="p-2"> Rp {{ number_format($d->total_tahunan, 0, ',', '.') }} </td>
                        <td class="p-2">
                            <div class="flex gap-2">
                                <a href="{{ route('penerima.edit', $d->id) }}" wire:navigate class="btn btn-xs btn-warning btn-soft btn-square tooltip tooltip-left" data-tip="Edit"><i class="ti ti-pencil text-lg"></i></a>
                                @if (!$d->rekap()->exists())
                                    <button class="btn btn-soft btn-xs btn-error btn-square tooltip tooltip-left" data-tip="Hapus" wire:click="delete({{ $d->id }})" wire:confirm="Hapus ?">
                                        <i class="ti ti-trash text-lg"></i></button>
                                @endif
                            </div>
                        </td>
                    </x-table.tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-4 text-center text-slate-500">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </x-table>
    </div>

</x-layouts.content>
