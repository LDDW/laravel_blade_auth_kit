<?php

use App\Http\Controllers\CurrentUserController;
use App\Http\Controllers\OtherBrowserSessionsController;
use App\Http\Controllers\ProfileController;
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

    Route::get('/user/profile', [ProfileController::class, 'show'])->name('profile.show');

    Route::post('/user/two-factor-recovery-codes/reveal', [ProfileController::class, 'showRecoveryCodes'])
        ->middleware('password.confirm')
        ->name('profile.two-factor.recovery-codes');

    Route::delete('/user/other-browser-sessions', [OtherBrowserSessionsController::class, 'destroy'])
        ->name('other-browser-sessions.destroy');

    Route::delete('/user', [CurrentUserController::class, 'destroy'])
        ->name('current-user.destroy');
});
