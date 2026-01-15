<x-layouts.content title="Pasien">

    <div class="card lg:w-[50%] border border-neutral-300">
        <div class="card-body">
            <h2 class="card-title">Tambah Data</h2>
            <form wire:submit="update">
                <input model="id" type="hidden" />
                <x-form.input label="NIK" model="nik" required />
                <x-form.input label="No Rekam Medis" model="no_rm" />
                <x-form.input label="Nama " model="full_name" required />
                <x-form.input label="Tanggal Lahir" model="dob" type="date" required />
                <x-form.select label="Jenis Kelamin" model="gender" :options="['L' => 'Laki-laki', 'P' => 'Perempuan']" required />
                <x-form.editor label="Alamat" model="address" required height="50px"/>

                <button class="btn btn-primary btn-soft mt-4">Simpan</button>
            </form>

        </div>
    </div>

</x-layouts.content>
