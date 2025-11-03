<div>
    <h1 class="text-2xl font-medium">Profile</h1>

    <div class="mt-6 lg:grid lg:grid-cols-3 gap-4">
        <div class="card mb-4 border ">
            <div class="card-body">
                <h3 class="font-semibold">Update Data</h3>
                <form wire:submit.prevent="updateEmail" class="mt-3 space-y-3">
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Nama</legend>
                        <input type="text" placeholder="name" class="input" wire:model="name">
                        @error('name')
                            <span class="text-error">{{ $message }}</span>
                        @enderror
                    </fieldset>
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Email</legend>
                        <input type="email" placeholder="Email" class="input" wire:model="email">
                        @error('email')
                            <span class="text-error">{{ $message }}</span>
                        @enderror
                    </fieldset>
                    <div>
                        <button class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border">
            <div class="card-body">
                <h3 class="font-semibold">Change Password</h3>
                <form wire:submit.prevent="updatePassword" class="mt-3 space-y-3">
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Current Password</legend>
                        <input type="password" wire:model="current_password" class="input" />
                        @error('current_password')
                            <span class="text-error">{{ $message }}</span>
                        @enderror
                    </fieldset>

                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">New Password</legend>
                        <input type="password" wire:model="password" class="input" />
                        @error('password')
                            <span class="text-error">{{ $message }}</span>
                        @enderror
                    </fieldset>
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Confirm New Password</legend>
                        <input type="password" wire:model="password_confirmation" class="input" />
                    </fieldset>
                    <div>
                        <button class="btn btn-primary">Change Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
