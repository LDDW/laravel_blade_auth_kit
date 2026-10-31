<x-guest-layout>
    <x-authentication-card>
        <x-slot name="title">{{ __('Verify your email') }}</x-slot>
        <x-slot name="description">
            {{ __('Before continuing, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </x-slot>

        <div class="grid gap-4">
            @if (session('status') == 'verification-link-sent')
                <div class="text-sm font-medium text-emerald-600 dark:text-emerald-400">
                    {{ __('A new verification link has been sent to the email address you provided in your profile settings.') }}
                </div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-button type="submit" class="w-full">
                    {{ __('Resend Verification Email') }}
                </x-button>
            </form>

            <div class="flex items-center justify-between text-sm">
                <a href="{{ route('profile.show') }}" class="font-medium underline-offset-4 hover:underline">
                    {{ __('Edit Profile') }}
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="font-medium text-muted-foreground underline-offset-4 hover:text-foreground hover:underline">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </x-authentication-card>
</x-guest-layout>
