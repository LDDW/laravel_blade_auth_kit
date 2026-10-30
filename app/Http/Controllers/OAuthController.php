<?php

namespace App\Http\Controllers;

use App\Enums\Providers;
use App\Models\User;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class OAuthController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return Socialite::driver(Providers::Github->value)
            ->scopes(['read:user', 'user:email'])
            ->redirect();
    }

    public function callback(Request $request): RedirectResponse
    {
        if ($request->has('error')) {
            return $this->failed(__('GitHub login was cancelled.'));
        }

        try {
            $githubUser = Socialite::driver(Providers::Github->value)->user();
        } catch (InvalidStateException) {
            return $this->failed(__('GitHub login expired. Please try again.'));
        } catch (ClientException) {
            return $this->failed(__('Unable to login with GitHub.'));
        }

        $email = $githubUser->getEmail();

        if (blank($email)) {
            return $this->failed(__('Your GitHub account has no verified email address.'));
        }

        $user = User::query()->where('github_id', (string) $githubUser->getId())->first();

        if (! $user) {
            $user = User::query()->where('email', $email)->first();

            if ($user) {
                $user->forceFill(['github_id' => (string) $githubUser->getId()])->save();
            } else {
                $user = User::query()->forceCreate([
                    'name' => $githubUser->getName() ?: $githubUser->getNickname() ?: 'GitHub User',
                    'email' => $email,
                    'github_id' => (string) $githubUser->getId(),
                    'email_verified_at' => now(),
                ]);
            }
        }

        if ($user->two_factor_confirmed_at) {
            $request->session()->put([
                'login.id' => $user->getKey(),
                'login.remember' => true,
            ]);

            return redirect()->route('two-factor.login');
        }

        Auth::login($user, remember: true);

        return redirect()->intended(config('fortify.home'));
    }

    private function failed(string $message): RedirectResponse
    {
        return redirect()->route('login')->withErrors(['email' => $message]);
    }
}
