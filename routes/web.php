<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth',
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/user/profile', [UserController::class, 'show'])->name('profile.show');

    Route::get('/user/passkeys/confirm-access', function () {
        return redirect()->route('profile.show');
    })->middleware('password.confirm')->name('passkeys.confirm-access');

    Route::post('/user/two-factor-recovery-codes/reveal', [UserController::class, 'showRecoveryCodes'])
        ->middleware('password.confirm')
        ->name('profile.two-factor.recovery-codes');

    Route::delete('/user', [UserController::class, 'destroy'])
        ->name('user.destroy');
});
