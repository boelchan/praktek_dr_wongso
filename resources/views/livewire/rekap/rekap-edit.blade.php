<x-layouts.content title="Transaksi">

    <div class="card w-84 border border-neutral-300">
        <div class="card-body">
            <h2 class="card-title">Edit Data</h2>
            <form wire:submit="update">
                <input model="id" type="hidden" />
                <x-form.input label="Tanggal" model="tanggal" type="date" />
                <x-form.select label="Penerima" model="penerimaId" :options="$penerimas" />
                <x-form.input label="Nominal" model="nominal" type="number" />

                <button class="btn btn-primary btn-soft mt-4">Simpan</button>
            </form>

        </div>
    </div>

</x-layouts.content>
