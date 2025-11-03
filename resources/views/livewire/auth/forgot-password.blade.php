<div class="relative flex min-h-screen w-full items-center justify-center">
    <div class="bg-base-100/60 card relative z-10 w-96 border border-slate-200 backdrop-blur-lg">
        <div class="card-body">
            <h2 class="card-title">Forgot Password</h2>

            @if ($status)
                <div class="alert alert-success">
                    {{ $status }}
                </div>
            @endif

            <form wire:submit.prevent="sendPasswordResetLink">
                <fieldset class="fieldset">
                    <legend class="fieldset-legend">Email</legend>
                    <input type="email" placeholder="email" class="input input-primary w-full" wire:model="email">
                    @error('email')
                        <span class="text-error">{{ $message }}</span>
                    @enderror
                </fieldset>
                <div class="form-control mt-6">
                    <button class="btn btn-primary btn-block btn-circle">Send Password Reset Link</button>
                </div>
            </form>
            <div class="divider">OR</div>
            <a href="{{ route('login') }}" class="btn btn-link">kembali ke Login</a>
        </div>
    </div>
    <div class='pointer-events-none absolute bottom-0 left-0 right-0 z-[1] h-[60vh] w-full bg-gradient-to-br from-cyan-200 via-indigo-800 to-violet-300 opacity-30 blur-[200px]'></div>

</div>
