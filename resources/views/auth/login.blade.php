<x-guest-layout>
    <x-authentication-card>
        <x-slot name="title">{{ __('Welcome back') }}</x-slot>
        <x-slot name="description">{{ __('Sign in with GitHub, a passkey, or your email.') }}</x-slot>

        <x-slot name="footer">
            @if (Route::has('register'))
                {{ __('No account?') }}
                <a href="{{ route('register') }}" class="font-medium text-foreground underline-offset-4 hover:underline">{{ __('Create one') }}</a>
            @endif
        </x-slot>

        <div class="grid gap-6" data-passkey-login>
            <x-validation-errors />

            @session('status')
                <div class="text-sm font-medium text-emerald-600 dark:text-emerald-400">
                    {{ $value }}
                </div>
            @endsession

            <div class="grid gap-2">
                <x-github-button />

                @if (Laravel\Fortify\Features::canManagePasskeys())
                    <div data-passkey-login-actions class="hidden">
                        <x-secondary-button type="button" class="w-full" data-passkey-login-button>
                            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                            </svg>
                            {{ __('Sign in with passkey') }}
                        </x-secondary-button>

                        <p data-passkey-login-error class="hidden text-sm text-destructive"></p>
                    </div>
                @endif
            </div>

            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <span class="w-full border-t"></span>
                </div>
                <div class="relative flex justify-center text-xs uppercase">
                    <span class="bg-card px-2 tracking-wide text-muted-foreground">{{ __('Or continue with email') }}</span>
                </div>
            </div>

            <form method="POST" action="{{ route('login') }}" class="grid gap-4">
                @csrf

                <div class="grid gap-2">
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input
                        id="email"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="{{ Laravel\Fortify\Features::canManagePasskeys() ? 'username webauthn' : 'username' }}"
                    />
                </div>

                <div class="grid gap-2">
                    <div class="flex items-center justify-between gap-3">
                        <x-label for="password" value="{{ __('Password') }}" />

                        @if (Route::has('password.request'))
                            <a class="text-sm text-muted-foreground underline-offset-4 hover:text-foreground hover:underline" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>
                    <x-input id="password" type="password" name="password" required autocomplete="current-password" />
                </div>

                <div class="flex items-center gap-2">
                    <x-checkbox id="remember_me" name="remember" />
                    <label for="remember_me" class="text-sm font-medium leading-none">{{ __('Remember me') }}</label>
                </div>

                <x-button class="w-full">
                    {{ __('Log in') }}
                </x-button>
            </form>
        </div>
    </x-authentication-card>
</x-guest-layout>
