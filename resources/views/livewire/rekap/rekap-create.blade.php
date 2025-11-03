<x-layouts.content title="Transaksi">

    <div class="flex flex-wrap gap-4">
        <div class="card w-84 border border-neutral-300">
            <div class="card-body">
                <h2 class="card-title">Tambah Data</h2>
                <form wire:submit="store">

                    <x-form.input label="Tanggal" model="tanggal" type="date" />
                    <x-form.select label="Penerima" model="penerimaId" :options="$penerimas" live />
                    <x-form.input label="Nominal" model="nominal" type="number" />

                    <button class="btn btn-primary btn-soft mt-4">Simpan</button>
                </form>

            </div>
        </div>

        <div class="card w-84 border border-neutral-300">
            <div class="card-body">
                <h2 class="card-title">Riwayat</h2>

                @if ($penerima)
                    <div class="flex gap-2">
                        Tahun ini Rp {{ number_format($penerima->total_tahunan ?? 0, 0, ',', '.') }}
                    </div>
                    <div class="flex gap-2">
                        Bulan ini Rp {{ number_format($penerima->total_bulanan ?? 0, 0, ',', '.') }}
                    </div>
                    <div class="flex gap-2">
                        Bulan lalu Rp {{ number_format($penerima->total_bulan_lalu ?? 0, 0, ',', '.') }}
                    </div>
                    <div class="divider m-0"></div>
                    <ul>
                        @forelse ($penerima->rekap as $r)
                            <li>{{ $r->tanggal }} <i class="ti ti-arrow-right"></i> Rp {{ number_format($r->nominal, 0, ',', '.') }}</li>
                        @empty
                            <li>Tidak ada riwayat</li>
                        @endforelse
                    </ul>
                @else
                    silahkan pilih penerima
                @endif

            </div>
        </div>

    </div>
</x-layouts.content>
