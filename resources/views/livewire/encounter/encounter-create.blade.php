<x-layouts.content title="Kunjungan">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        .select2-dropdown {
  background-color: white;
  border: 1px solid #aaa;
  border-radius: 4px;
  box-sizing: border-box;
  display: block;
  position: absolute;
  left: -100000px;
  width: 100%;
  z-index: 1051; }
          .select2-dropdown {
  @apply absolute block w-auto box-border bg-white border-solid border-2 border-gray-600 z-50 float-left;
  }
    </style>
    
    <div class="grid lg:grid-cols-3 gap-4">

        <div class="card w-84 lg:w-full lg:col-span-2 min-w-84 border border-neutral-300">
            <div class="card-body">
                <h2 class="card-title">Tambah Data</h2>
                <form wire:submit="store" class="lg:grid grid-cols-2 gap-10 gap-y-0">
                    <div>
                        <x-form.input label="Tanggal" model="encounter_date" type="date" required />
                        <x-form.select label="Pasien" model="patientId" :options="$patients" required live />
                        <x-form.input label="Keluhan" model="condition_keluhan" />
                        <fieldset class="fieldset">
                            <legend class="fieldset-legend">Tekanan Darah </legend>
                            <label class="input">
                                <input type="number" wire:model="observation_sistolic" placeholder="sistolic" />
                                <span class="label">/</span>
                                <input type="number" wire:model="observation_diastolic" placeholder="diastolic" />
                            </label>
                        </fieldset>
                    </div>
                    <div>
                        <x-form.textarea label="Lab" model="specimen" rows="5" />
                        <x-form.textarea label="Obat" model="medication" rows="5" />
                    </div>

                    <div class="col-span-2">
                        <x-form.textarea label="Keterangan" model="encounter_keterangan" rows="5" />
                        <button class="btn btn-primary btn-soft mt-4 w-full">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border border-neutral-300">
            <div class="card-body">
                <h2 class="card-title">5 Kunjungan terkahir</h2>
                @forelse ($riwayat as $k)
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
                                @if (!$loop->last)
                                    /
                                @endif
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

    <script>
        $('#patientId').select2()
    </script>
</x-layouts.content>
