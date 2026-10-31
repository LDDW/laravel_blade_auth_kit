<x-guest-layout>
    <x-authentication-card>
        <x-slot name="title">{{ __('Create an account') }}</x-slot>
        <x-slot name="description">{{ __('Get started with GitHub or your email.') }}</x-slot>

        <x-slot name="footer">
            {{ __('Already registered?') }}
            <a href="{{ route('login') }}" class="font-medium text-foreground underline-offset-4 hover:underline">{{ __('Log in') }}</a>
        </x-slot>

        <div class="grid gap-6">
            <x-validation-errors />

            <x-github-button />

            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <span class="w-full border-t"></span>
                </div>
                <div class="relative flex justify-center text-xs uppercase">
                    <span class="bg-card px-2 tracking-wide text-muted-foreground">{{ __('Or continue with email') }}</span>
                </div>
            </div>

            <form method="POST" action="{{ route('register') }}" class="grid gap-4">
                @csrf

                <div class="grid gap-2">
                    <x-label for="name" value="{{ __('Name') }}" />
                    <x-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                </div>

                <div class="grid gap-2">
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" />
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
                    {{ __('Register') }}
                </x-button>
            </form>
        </div>
    </x-authentication-card>
</x-guest-layout>
