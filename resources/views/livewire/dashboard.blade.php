<x-layouts.content title="Dashboard">

    <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
        <div class="card border border-neutral-300 hover:shadow-md transition p-4">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="card-title text-sm text-gray-500">Kunjungan Hari ini</h2>
                    <div class="mt-2 flex items-baseline">
                        <span class="text-2xl font-semibold text-gray-900">{{ number_format($total_hari, 0, ',', '.') }}</span>
                    </div>
                    <p class="mt-3 text-xs text-gray-500">Transaksi yang tercatat hari ini.</p>
                </div>
                <div class="ml-4 text-gray-400">
                    <!-- icon: clock -->
                    <svg class="w-10 h-10 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3M12 21a9 9 0 100-18 9 9 0 000 18z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="card border border-neutral-300 hover:shadow-md transition p-4">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="card-title text-sm text-gray-500">Kunjungan Bulan ini</h2>
                    <div class="mt-2 flex items-baseline">
                        <span class="text-2xl font-semibold text-gray-900">{{ number_format($total_bulan, 0, ',', '.') }}</span>
                    </div>
                    <p class="mt-3 text-xs text-gray-500">Transaksi yang tercatat di bulan ini.</p>
                </div>
                <div class="ml-4 text-gray-400">
                    <!-- icon: calendar -->
                    <svg class="w-10 h-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3M3 11h18M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 mt-4">
        <a href="{{ route('encounter.index') }}" wire:navigate class="btn btn-success btn-dash "> Lihat Kunjungan</a>
        <a href="{{ route('patient.index') }}" wire:navigate class="btn btn-info btn-dash "> Lihat Pasien</a>
    </div>

</x-layouts.content>
