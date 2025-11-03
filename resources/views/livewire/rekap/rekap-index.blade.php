<x-layouts.content title="Transaksi">

    <div>
        <x-table.filter :open="$open">
            <x-slot:action>
                <a href="{{ route('rekap.create') }}" wire:navigate class="btn btn-soft btn-primary w-10 h-10 lg:w-auto">
                    <i class="ti ti-plus text-lg"></i> <span class="hidden lg:inline">Tambah</span>
                </a>
            </x-slot:action>

            <x-form.input label="Tanggal" model="search_tanggal" floating live type="date" />
            <x-form.input label="Nama Rekening" model="search_nama_rekening" floating live />
            <x-form.input label="No Rekening" model="search_nomor_rekening" floating live />
            <x-form.input label="Nominal" model="search_nominal" floating live type="number" />
            <x-form.input label="Alamat" model="search_alamat" floating live />

        </x-table.filter>

        <x-table :paginate="$data">
            <x-table.thead :sortField="$sortField" :sortDirection="$sortDirection">
                <x-table.th width="3%" />
                <x-table.th label="Tanggal" sort="tanggal" width="10%" />
                <x-table.th label="Penerima" sort="nama_rekening" width="15%" />
                <x-table.th label="No Rekening" sort="no_rekening" width="15%" />
                <x-table.th label="Nominal" sort="nominal" width="15%" />
                <x-table.th label="Alamat" width="20%" />
                <x-table.th label="User" sort="created_by" width="15%" />
                <x-table.th width="12%" />
            </x-table.thead>

            <tbody>
                @forelse ($data as $index => $d)
                    <x-table.tr>
                        <td class="p-2"> {{ $index + 1 }} </td>
                        <td class="p-2"> {{ $d->tanggal }} </td>
                        <td class="p-2"> {{ $d->nama_rekening }} </td>
                        <td class="p-2"> {{ $d->nomor_rekening }} </td>
                        <td class="p-2"> Rp {{ number_format($d->nominal, 0, ',', '.') }} </td>
                        <td class="p-2"> {{ $d->alamat }} </td>
                        <td class="p-2"> {{ $d->user->name }} </td>
                        <td class="p-2">
                            <div class="flex gap-2">
                                @if ($d->created_by == auth()->user()->id)
                                    <a href="{{ route('rekap.edit', [$d->id, 'uuid'=> $d->uuid]) }}" wire:navigate class="btn btn-xs btn-warning btn-soft btn-square tooltip tooltip-left" data-tip="Edit"><i class="ti ti-pencil text-lg"></i></a>
                                    <button class="btn btn-soft btn-xs btn-error btn-square tooltip tooltip-left" data-tip="Hapus" wire:click="delete({{ $d->id }})" wire:confirm="Hapus ?">
                                        <i class="ti ti-trash text-lg"></i></button>
                                @endif
                            </div>
                        </td>
                    </x-table.tr>
                @empty
                    <tr>
                        <td colspan="8" class="p-4 text-center text-slate-500">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </x-table>
    </div>

</x-layouts.content>
