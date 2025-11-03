<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Password;
use Livewire\Component;

class ForgotPassword extends Component
{
    public $email;

    public $status;

    protected $rules = [
        'email' => 'required|email',
    ];

    public function sendPasswordResetLink()
    {
        $this->validate();

        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT) {
            session()->flash('status', trans($status));

            return redirect()->route('password.request');
        }

        $this->addError('email', trans($status));
    }

    public function render()
    {
        return view('livewire.auth.forgot-password');
    }
}
