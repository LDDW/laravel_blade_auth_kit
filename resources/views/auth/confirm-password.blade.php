<x-guest-layout>
    <x-authentication-card>
        <x-slot name="title">{{ __('Confirm your password') }}</x-slot>
        <x-slot name="description">{{ __('This is a secure area of the application. Please confirm your password before continuing.') }}</x-slot>

        <div class="grid gap-4">
            <x-validation-errors />

            <form method="POST" action="{{ route('password.confirm') }}" class="grid gap-4">
                @csrf

                <div class="grid gap-2">
                    <x-label for="password" value="{{ __('Password') }}" />
                    <x-input id="password" type="password" name="password" required autocomplete="current-password" autofocus />
                </div>

                <x-button class="w-full">
                    {{ __('Confirm') }}
                </x-button>
            </form>
        </div>
    </x-authentication-card>
</x-guest-layout>
