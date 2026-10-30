<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Laravel\Passkeys\Passkey;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Passkey::deleting(function (Passkey $passkey): void {
            $user = $passkey->user;

            if (! $user instanceof User) {
                return;
            }

            abort_if(
                $user->loginMethodsCount() <= 1,
                422,
                __('You cannot remove your last sign-in method.'),
            );
        });
    }
}
