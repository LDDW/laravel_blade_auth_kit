<x-guest-layout>
    <x-authentication-card>
        <x-slot name="title">{{ __('Two-factor authentication') }}</x-slot>

        <div data-two-factor-challenge class="grid gap-4">
            <p class="text-sm text-muted-foreground" data-recovery-hide>
                {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
            </p>

            <p class="hidden text-sm text-muted-foreground" data-recovery-show>
                {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
            </p>

            <x-validation-errors />

            <form method="POST" action="{{ route('two-factor.login') }}" class="grid gap-4">
                @csrf

                <div class="grid gap-2" data-recovery-hide>
                    <x-label for="code" value="{{ __('Code') }}" />
                    <x-input id="code" type="text" inputmode="numeric" name="code" autofocus autocomplete="one-time-code" />
                </div>

                <div class="hidden" data-recovery-show>
                    <div class="grid gap-2">
                        <x-label for="recovery_code" value="{{ __('Recovery Code') }}" />
                        <x-input id="recovery_code" type="text" name="recovery_code" autocomplete="one-time-code" />
                    </div>
                </div>

                <div class="grid gap-3">
                    <button type="button" class="justify-self-start text-sm font-medium text-muted-foreground underline-offset-4 hover:text-foreground hover:underline" data-recovery-hide data-toggle-recovery>
                        {{ __('Use a recovery code') }}
                    </button>

                    <button type="button" class="hidden justify-self-start text-sm font-medium text-muted-foreground underline-offset-4 hover:text-foreground hover:underline" data-recovery-show data-toggle-recovery>
                        {{ __('Use an authentication code') }}
                    </button>

                    <x-button class="w-full">
                        {{ __('Log in') }}
                    </x-button>
                </div>
            </form>
        </div>
    </x-authentication-card>
</x-guest-layout>
