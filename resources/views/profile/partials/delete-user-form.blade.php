<x-action-section>
    <x-slot name="title">
        {{ __('Delete Account') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Permanently delete your account.') }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </div>

        <div class="mt-5">
            <x-danger-button type="button" data-open-modal="confirm-user-deletion">
                {{ __('Delete Account') }}
            </x-danger-button>
        </div>

        <x-dialog-modal name="confirm-user-deletion">
            <x-slot name="title">
                {{ __('Delete Account') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}

                <form method="POST" action="{{ route('current-user.destroy') }}" id="delete-user-form" class="mt-4">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="password_confirmation_context" value="confirm-user-deletion">

                    <x-input type="password" name="password" class="mt-1 block w-3/4" autocomplete="current-password" placeholder="{{ __('Password') }}" />
                    <x-input-error for="password" class="mt-2" />
                </form>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button type="button" data-close-modal="confirm-user-deletion">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3" form="delete-user-form">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    </x-slot>
</x-action-section>
