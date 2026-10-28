<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Laravel\Fortify\Actions\ConfirmPassword;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;

class UserController extends Controller
{
    /**
     * Affiche la page de profil.
     */
    public function show(Request $request): View
    {
        $this->validateTwoFactorAuthenticationState($request);

        $user = $request->user();
        $showingRecoveryCodes = in_array(session('status'), [
            Fortify::RECOVERY_CODES_GENERATED,
            'recovery-codes-revealed',
        ], true) && $user->two_factor_confirmed_at;

        if (Features::canManagePasskeys()) {
            $user->load('passkeys');
        }

        return view('profile.show', [
            'user' => $user,
            'showingRecoveryCodes' => $showingRecoveryCodes ? $user->recoveryCodes() : [],
            'confirmsTwoFactorAuthentication' => Features::optionEnabled(
                Features::twoFactorAuthentication(),
                'confirm'
            ),
        ]);
    }

    /**
     * Affiche les codes de récupération 2FA (après confirmation de mot de passe via middleware).
     */
    public function showRecoveryCodes(Request $request): RedirectResponse
    {
        return back()->with('status', 'recovery-codes-revealed');
    }

    /**
     * Supprime le compte de l'utilisateur authentifié.
     */
    public function destroy(Request $request, StatefulGuard $guard): RedirectResponse
    {
        $confirmed = app(ConfirmPassword::class)(
            $guard,
            $request->user(),
            $request->password
        );

        if (! $confirmed) {
            throw ValidationException::withMessages([
                'password' => __('The password is incorrect.'),
            ]);
        }

        $user = $request->user();

        $guard->logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Annule une activation 2FA non confirmée si l'utilisateur quitte le flux.
     *
     * Logique alignée sur le concern Jetstream ConfirmsTwoFactorAuthentication (Inertia).
     */
    protected function validateTwoFactorAuthenticationState(Request $request): void
    {
        if (! Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm')) {
            return;
        }

        $user = $request->user();
        $currentTime = time();

        if (is_null($user->two_factor_secret) && is_null($user->two_factor_confirmed_at)) {
            $request->session()->put('two_factor_empty_at', $currentTime);
        }

        if (
            ! is_null($user->two_factor_secret)
            && is_null($user->two_factor_confirmed_at)
            && $request->session()->has('two_factor_empty_at')
            && is_null($request->session()->get('two_factor_confirming_at'))
        ) {
            $request->session()->put('two_factor_confirming_at', $currentTime);
        }

        if (
            ! array_key_exists('code', $request->session()->getOldInput())
            && is_null($user->two_factor_confirmed_at)
            && $request->session()->get('two_factor_confirming_at', 0) != $currentTime
            && ! is_null($user->two_factor_secret)
        ) {
            app(DisableTwoFactorAuthentication::class)($user);

            $request->session()->put('two_factor_empty_at', $currentTime);
            $request->session()->remove('two_factor_confirming_at');
        }
    }
}
