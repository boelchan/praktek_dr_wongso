<div>
    <div class="flex items-center justify-center min-h-screen bg-base-200">
        <div class="card w-96 bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title">Reset Password</h2>
                <form wire:submit.prevent="resetPassword">
                    <input type="hidden" wire:model="token">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Email</span>
                        </label>
                        <input type="email" placeholder="email" class="input input-bordered" wire:model="email">
                        @error('email') <span class="text-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Password</span>
                        </label>
                        <input type="password" placeholder="password" class="input input-bordered" wire:model="password">
                        @error('password') <span class="text-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Confirm Password</span>
                        </label>
                        <input type="password" placeholder="confirm password" class="input input-bordered" wire:model="password_confirmation">
                    </div>
                    <div class="form-control mt-6">
                        <button class="btn btn-primary">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
