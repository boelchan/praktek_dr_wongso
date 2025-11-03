<?php

use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Profile;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Dashboard;
use App\Livewire\Encounter\EncounterCreate;
use App\Livewire\Encounter\EncounterEdit;
use App\Livewire\Encounter\EncounterIndex;
use App\Livewire\Patient\PatientCreate;
use App\Livewire\Patient\PatientEdit;
use App\Livewire\Patient\PatientIndex;
use App\Livewire\Patient\PatientShow;
use App\Livewire\User\UserIndex;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return to_route('dashboard');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::get('/patient', PatientIndex::class)->name('patient.index');
    Route::get('/patient/create', PatientCreate::class)->name('patient.create');
    Route::get('/patient/{patient}/edit', PatientEdit::class)->name('patient.edit');
    Route::get('/patient/{patient}', PatientShow::class)->name('patient.show');

    Route::get('/encounter', EncounterIndex::class)->name('encounter.index');
    Route::get('/encounter/create', EncounterCreate::class)->name('encounter.create');
    Route::get('/encounter/{encounter}/edit', EncounterEdit::class)->name('encounter.edit');
});

Route::middleware('guest')->group(function () {
    // Route::get('/register', Register::class)->name('register');
    Route::get('/login', Login::class)->name('login');
    Route::get('/forgot-password', ForgotPassword::class)->name('password.request');
    Route::get('/reset-password/{token}', ResetPassword::class)->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/user', UserIndex::class)->name('user');

    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/login');
    })->name('logout');
});

// });
