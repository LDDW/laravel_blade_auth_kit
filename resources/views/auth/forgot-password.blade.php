<x-guest-layout>
    <x-authentication-card>
        <x-slot name="title">{{ __('Reset your password') }}</x-slot>
        <x-slot name="description">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </x-slot>

        <x-slot name="footer">
            <a href="{{ route('login') }}" class="font-medium text-foreground underline-offset-4 hover:underline">{{ __('Back to log in') }}</a>
        </x-slot>

        <div class="grid gap-4">
            @session('status')
                <div class="text-sm font-medium text-emerald-600 dark:text-emerald-400">
                    {{ $value }}
                </div>
            @endsession

            <x-validation-errors />

            <form method="POST" action="{{ route('password.email') }}" class="grid gap-4">
                @csrf

                <div class="grid gap-2">
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                </div>

                <x-button class="w-full">
                    {{ __('Email Password Reset Link') }}
                </x-button>
            </form>
        </div>
    </x-authentication-card>
</x-guest-layout>
