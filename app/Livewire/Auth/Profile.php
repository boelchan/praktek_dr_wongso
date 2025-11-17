<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Profile extends Component
{
    public $name;

    public $email;

    public $current_password;

    public $password;

    public $password_confirmation;

    public function mount()
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    public function updated($field)
    {
        $this->validateOnly($field, $this->rules($field));
    }

    protected function rules($field = null)
    {
        $userId = Auth::id();

        return [
            'email' => 'required|email|unique:users,email,'.$userId,
            'current_password' => 'required_with:password|string',
            'password' => 'nullable|confirmed|min:8',
        ];
    }

    public function updateEmail()
    {
        $this->validate(['email' => 'required|email|unique:users,email,'.Auth::id()]);
        $this->validate(['name' => 'required']);

        $user = Auth::user();

        $user->name = $this->name;
        $user->email = $this->email;
        $user->save();

        // $newEmail = $this->email;
        // create a temporary signed URL valid for 60 minutes
        // $url = url()->temporarySignedRoute(
        //     'email.change.verify',
        //     now()->addMinutes(60),
        //     ['id' => $user->id, 'email' => $newEmail]
        // );

        // send email to the new address with verification link
        // \Illuminate\Support\Facades\Mail::to($newEmail)->send(new \App\Mail\VerifyNewEmail($url));

        return redirect()->route('profile');
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required|string',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = Auth::user();

        if (! Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'The current password is incorrect.');

            return;
        }

        $user->password = Hash::make($this->password);
        $user->save();

        // clear password fields
        $this->current_password = '';
        $this->password = '';
        $this->password_confirmation = '';

        session()->flash('status', 'Password updated successfully.');

        return redirect()->route('profile');
    }

    public function render()
    {
        return view('livewire.auth.profile');
    }
}
