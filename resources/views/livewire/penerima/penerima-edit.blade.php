<x-layouts.content title="Transaksi">

    <div class="card w-84 border border-neutral-300">
        <div class="card-body">
            <h2 class="card-title">Edit Data</h2>
            <form wire:submit="update">
                <input model="id" type="hidden"/>
                <x-form.input label="Nama Rekening" model="nama" />
                <x-form.input label="No Rekening" model="nomor_rekening" />
                <x-form.input label="Alamat" model="alamat" />

                <button class="btn btn-primary btn-soft mt-4">Simpan</button>
            </form>

        </div>
    </div>

</x-layouts.content>
