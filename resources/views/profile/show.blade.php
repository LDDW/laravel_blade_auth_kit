<x-app-layout>
    <x-slot name="header">
        <h1 class="truncate text-sm font-semibold tracking-tight">
            {{ __('Profile') }}
        </h1>
    </x-slot>

    <div class="mx-auto flex w-full max-w-3xl flex-col gap-10">
        @if (Laravel\Fortify\Features::canUpdateProfileInformation())
            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $user->hasVerifiedEmail())
                <form id="resend-verification" method="POST" action="{{ route('verification.send') }}" class="hidden">
                    @csrf
                </form>
            @endif

            @include('profile.partials.update-profile-information-form')
        @endif

        @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
            @include('profile.partials.update-password-form')
        @endif

        @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication() && $user->hasPassword())
            @include('profile.partials.two-factor-authentication-form')
        @endif

        @if (Laravel\Fortify\Features::canManagePasskeys())
            @include('profile.partials.manage-passkeys-form')
        @endif

        @include('profile.partials.delete-user-form')
    </div>

    @if ($errors->has('password') && old('password_confirmation_context'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                document.querySelector('dialog[data-modal="{{ old('password_confirmation_context') }}"]')?.showModal();
            });
        </script>
    @endif
</x-app-layout>
