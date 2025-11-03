<x-layouts.content title="Pasien">
    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Card Detail Pasien -->
        <div class="card border border-base-300 sticky">
            <div class="card-body">
                <h2 class="card-title">Detail</h2>
                <div class="mt-2 space-y-2 text-sm">
                    <p><span class="font-semibold">No. RM :</span> {{ $pasien->no_rm ?? '-' }}</p>
                    <p><span class="font-semibold">NIK :</span> {{ $pasien->nik }}</p>
                    <p>
                        <span class="font-semibold">Nama :</span>
                        {{ $pasien->full_name }}
                        <span class="badge badge-outline ml-2">{{ ucfirst($pasien->gender) }}</span>
                    </p>
                    <p><span class="font-semibold">Tanggal Lahir :</span> {{ $pasien->dob }}</p>
                    <p><span class="font-semibold">Alamat :</span> {{ $pasien->address }}</p>
                    <p>
                        <span class="badge {{ $pasien->status == 'active' ? 'badge-success' : 'badge-error' }}">
                            {{ ucfirst($pasien->status) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Card Riwayat Pemeriksaan -->
        <div class="card border border-base-300 lg:col-span-2">
            <div class="card-body">
                <div class="flex gap-2">

                    <h2 class="card-title">Riwayat Kunjungan</h2> <a href="{{ route('encounter.create', ['patient_id'=>$pasien->id])}}" class="btn btn-soft btn-primary"><i class="ti ti-plus text-lg"></i> Tambah</a>
                </div>

                @forelse ($pasien->encounter as $k)
                    <div class="mt-3 border border-base-200 rounded-xl p-3 bg-base-200 transition">
                        <div class="flex justify-between text-sm">
                            <span class="font-semibold">{{ $k->encounter_date }}</span>
                            <span class="text-xs opacity-70">#{{ $loop->iteration }}</span>
                        </div>
                        <p class="mt-1"><span class="font-semibold">Keluhan :</span> {{ $k->keluhan_utama ?? '-' }}</p>
                        <p class="mt-1">
                            <span class="font-semibold">Tekanan Darah : </span>
                            @foreach ($k->observation as $o)
                                {{ $o->value }}
                                @if (!$loop->last) / @endif
                            @endforeach
                        </p>

                        @if ($k->medication)
                            <p class="mt-1"><span class="font-semibold">Obat :</span> {!! optional($k->medication)->value !!}</p>
                        @endif
                        @if ($k->specimen)
                            <p class="mt-1"><span class="font-semibold">Lab :</span> {!! optional($k->specimen)->value !!}</p>
                        @endif
                        <p class="mt-1"><span class="font-semibold">Keterangan:</span> {{ $k->keterangan ?? '-' }}</p>
                    </div>
                @empty
                    <p class="text-sm text-neutral-500 italic mt-2">Belum ada riwayat pemeriksaan.</p>
                @endforelse
            </div>
        </div>
    </div>

</x-layouts.content>
