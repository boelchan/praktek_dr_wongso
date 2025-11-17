<x-layouts.content title="Kunjungan">
    <div class="card w-84 lg:w-[80%] min-w-84 border border-neutral-300">
        <div class="card-body">
            <h2 class="card-title">Edit Data</h2>
            <form wire:submit="update" class="lg:grid grid-cols-2 gap-10 gap-y-0">
                <input type="hidden" wire:model="encounter_id">
                <input type="hidden" wire:model="observation_id">

                <div>
                    <x-form.input label="Tanggal" model="encounter_date" type="date" required />
                    <x-form.select label="Pasien" model="patient_id" :options="$patients" required />
                    <x-form.input label="Keluhan" model="condition_keluhan" />
                    <legend class="fieldset-legend">Tekanan Darah </legend>
                    <fieldset class="fieldset">
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
</x-layouts.content>
