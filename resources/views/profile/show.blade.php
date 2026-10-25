<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $user->hasVerifiedEmail())
                    <form id="resend-verification" method="POST" action="{{ route('verification.send') }}" class="hidden">
                        @csrf
                    </form>
                @endif

                @include('profile.partials.update-profile-information-form')

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @include('profile.partials.update-password-form')
                </div>

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @include('profile.partials.two-factor-authentication-form')
                </div>

                <x-section-border />
            @endif

            <div class="mt-10 sm:mt-0">
                @include('profile.partials.logout-other-browser-sessions-form')
            </div>

            <x-section-border />

            <div class="mt-10 sm:mt-0">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>

    @if ($errors->has('password') && old('password_confirmation_context'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                document.querySelector('dialog[data-modal="{{ old('password_confirmation_context') }}"]')?.showModal();
            });
        </script>
    @endif
</x-app-layout>
