<x-guest-layout>
    <x-authentication-card>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ $value }}
            </div>
        @endsession

        <div data-passkey-login class="space-y-4">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input
                        id="email"
                        class="block mt-1 w-full"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="{{ Laravel\Fortify\Features::canManagePasskeys() ? 'username webauthn' : 'username' }}"
                    />
                </div>

                <div class="mt-4">
                    <x-label for="password" value="{{ __('Password') }}" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                </div>

                <div class="block mt-4">
                    <label for="remember_me" class="flex items-center">
                        <x-checkbox id="remember_me" name="remember" />
                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-button class="ms-4">
                        {{ __('Log in') }}
                    </x-button>
                </div>
            </form>

            @if (Laravel\Fortify\Features::canManagePasskeys())
                <div data-passkey-login-actions class="hidden">
                    <div class="relative flex items-center py-1">
                        <div class="flex-grow border-t border-gray-300 dark:border-gray-600"></div>
                        <span class="mx-3 flex-shrink text-xs uppercase text-gray-500 dark:text-gray-400">{{ __('Or') }}</span>
                        <div class="flex-grow border-t border-gray-300 dark:border-gray-600"></div>
                    </div>

                    <x-secondary-button type="button" class="w-full justify-center" data-passkey-login-button>
                        {{ __('Sign in with passkey') }}
                    </x-secondary-button>

                    <p data-passkey-login-error class="hidden mt-2 text-sm text-red-600 dark:text-red-400"></p>
                </div>
            @endif
        </div>
    </x-authentication-card>
</x-guest-layout>
