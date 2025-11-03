<x-layouts.content title="Penerima">

    <div class="card w-84 border border-neutral-300">
        <div class="card-body">
            <h2 class="card-title">Tambah Data</h2>
            <form wire:submit="store">
                <x-form.input label="Nama Rekening" model="nama" />
                <x-form.input label="Nomor Rekening" model="nomor_rekening" />
                <x-form.input label="Alamat" model="alamat" />

                <button class="btn btn-primary btn-soft mt-4">Simpan</button>
            </form>

        </div>
    </div>

</x-layouts.content>
