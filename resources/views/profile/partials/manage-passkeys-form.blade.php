<x-action-section>
    <x-slot name="title">
        {{ __('Passkeys') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Sign in with Face ID, Touch ID, Windows Hello, or a hardware security key.') }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
            <p>
                {{ __('Passkeys let you sign in without a password using Face ID, Touch ID, Windows Hello, or a security key.') }}
            </p>
        </div>

        @if ($user->passkeys->isNotEmpty())
            <div class="mt-5 space-y-4" data-passkey-list>
                @foreach ($user->passkeys as $passkey)
                    <div class="flex items-center justify-between gap-4" data-passkey-id="{{ $passkey->id }}">
                        <div class="min-w-0">
                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
                                {{ $passkey->name }}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                @if ($passkey->authenticator)
                                    {{ $passkey->authenticator }} ·
                                @endif
                                {{ __('Added') }} {{ $passkey->created_at?->diffForHumans() }}
                                @if ($passkey->last_used_at)
                                    · {{ __('Last used') }} {{ $passkey->last_used_at->diffForHumans() }}
                                @endif
                            </div>
                        </div>

                        <x-danger-button
                            type="button"
                            data-passkey-delete
                            data-passkey-id="{{ $passkey->id }}"
                        >
                            {{ __('Remove') }}
                        </x-danger-button>
                    </div>
                @endforeach
            </div>
        @else
            <div class="mt-5 text-sm text-gray-600 dark:text-gray-400">
                {{ __('You have not registered any passkeys yet.') }}
            </div>
        @endif

        <div class="mt-5 flex flex-wrap items-center gap-3 hidden" data-passkey-register>
            <x-button type="button" data-open-modal="register-passkey">
                {{ __('Add Passkey') }}
            </x-button>

            <x-action-message on="passkey-registered">
                {{ __('Passkey registered.') }}
            </x-action-message>

            <x-action-message on="passkey-deleted">
                {{ __('Passkey removed.') }}
            </x-action-message>
        </div>

        <p data-passkey-unsupported class="hidden mt-5 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Passkeys are not supported in this browser.') }}
        </p>

        <p data-passkey-manage-error class="hidden mt-3 text-sm text-red-600 dark:text-red-400"></p>

        <x-dialog-modal name="register-passkey">
            <x-slot name="title">
                {{ __('Add Passkey') }}
            </x-slot>

            <x-slot name="content">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Give this passkey a name, then your browser will ask you to create it (Touch ID, Face ID, or your password manager).') }}
                </p>

                <div class="mt-4">
                    <x-label for="passkey-name" value="{{ __('Name') }}" />
                    <x-input
                        id="passkey-name"
                        type="text"
                        class="mt-1 block w-3/4"
                        data-passkey-name
                        maxlength="255"
                        placeholder="{{ __('e.g. MacBook Pro') }}"
                        autocomplete="off"
                    />
                </div>

                <p data-passkey-modal-error class="hidden mt-3 text-sm text-red-600 dark:text-red-400"></p>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button type="button" data-close-modal="register-passkey">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-button
                    class="ms-3"
                    type="button"
                    data-passkey-register-submit
                >
                    {{ __('Continue') }}
                </x-button>
            </x-slot>
        </x-dialog-modal>
    </x-slot>
</x-action-section>
