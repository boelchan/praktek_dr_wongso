<div class="max-w-xl mx-auto">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title">Verify Your Email Address</h2>

            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success">A new verification link has been sent to your email address.</div>
            @endif

            <p class="mt-4">Before proceeding, please check your email for a verification link. If you did not receive the email, click the button below to request another.</p>

            <form method="POST" action="{{ route('verification.send') }}" class="mt-4">
                @csrf
                <button type="submit" class="btn btn-primary">Resend Verification Email</button>
            </form>
        </div>
    </div>
</div>
