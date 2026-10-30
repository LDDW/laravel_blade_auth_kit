<x-form-section action="{{ route('user-password.update') }}" method="PUT">
    <x-slot name="title">
        {{ $user->hasPassword() ? __('Update Password') : __('Set Password') }}
    </x-slot>

    <x-slot name="description">
        @if ($user->hasPassword())
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        @else
            {{ __('Set a password to also sign in with email, or if you lose access to GitHub.') }}
        @endif
    </x-slot>

    <x-slot name="form">
        @if ($user->hasPassword())
            <div class="col-span-6 sm:col-span-4">
                <x-label for="current_password" value="{{ __('Current Password') }}" />
                <x-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
                <x-input-error for="current_password" class="mt-2" />
            </div>
        @endif

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password" value="{{ $user->hasPassword() ? __('New Password') : __('Password') }}" />
            <x-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error for="password" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
            <x-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error for="password_confirmation" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="password-updated">
            {{ __('Saved.') }}
        </x-action-message>

        <x-button>
            {{ $user->hasPassword() ? __('Save') : __('Set Password') }}
        </x-button>
    </x-slot>
</x-form-section>
