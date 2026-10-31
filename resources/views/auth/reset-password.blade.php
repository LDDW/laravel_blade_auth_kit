<x-guest-layout>
    <x-authentication-card>
        <x-slot name="title">{{ __('Choose a new password') }}</x-slot>
        <x-slot name="description">{{ __('Enter a new password for your account.') }}</x-slot>

        <div class="grid gap-4">
            <x-validation-errors />

            <form method="POST" action="{{ route('password.update') }}" class="grid gap-4">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="grid gap-2">
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                </div>

                <div class="grid gap-2">
                    <x-label for="password" value="{{ __('Password') }}" />
                    <x-input id="password" type="password" name="password" required autocomplete="new-password" />
                </div>

                <div class="grid gap-2">
                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                    <x-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
                </div>

                <x-button class="w-full">
                    {{ __('Reset Password') }}
                </x-button>
            </form>
        </div>
    </x-authentication-card>
</x-guest-layout>
