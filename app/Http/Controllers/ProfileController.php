<?php

namespace App\Http\Controllers;

use App\Support\UserAgent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;

class ProfileController extends Controller
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
            'sessions' => $this->sessions($request),
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
     * @return Collection<int, object>
     */
    protected function sessions(Request $request)
    {
        if (config('session.driver') !== 'database') {
            return collect();
        }

        return collect(
            DB::connection(config('session.connection'))
                ->table(config('session.table', 'sessions'))
                ->where('user_id', $request->user()->getAuthIdentifier())
                ->orderByDesc('last_activity')
                ->get()
        )->map(function (object $session) use ($request): object {
            $agent = new UserAgent($session->user_agent ?? '');

            return (object) [
                'agent' => [
                    'is_desktop' => $agent->isDesktop(),
                    'platform' => $agent->platform(),
                    'browser' => $agent->browser(),
                ],
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id === $request->session()->getId(),
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        });
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
