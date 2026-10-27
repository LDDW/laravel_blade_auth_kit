import './bootstrap';
import './theme';

const csrfHeaders = () => {
    const headers = {
        Accept: 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
    };

    const meta = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (meta) {
        headers['X-CSRF-TOKEN'] = meta;
    }

    return headers;
};

const isUserCancelled = (error) => error?.name === 'UserCancelledError';

const showError = (element, message) => {
    if (!element) {
        return;
    }

    element.textContent = message;
    element.classList.remove('hidden');
};

const clearError = (element) => {
    if (!element) {
        return;
    }

    element.textContent = '';
    element.classList.add('hidden');
};

const rememberFromCheckbox = () => document.querySelector('#remember_me')?.checked === true;

const initPasskeyLogin = () => {
    const root = document.querySelector('[data-passkey-login]');
    if (!root || !window.Passkeys?.isSupported()) {
        return;
    }

    const actions = root.querySelector('[data-passkey-login-actions]');
    const button = root.querySelector('[data-passkey-login-button]');
    const errorEl = root.querySelector('[data-passkey-login-error]');

    actions?.classList.remove('hidden');

    const redirectAfterLogin = (response) => {
        window.location.href = response?.redirect || '/dashboard';
    };

    window.Passkeys.autofill({
        remember: rememberFromCheckbox,
    }).then((response) => {
        if (response) {
            redirectAfterLogin(response);
        }
    }).catch(() => {
        // Autofill is optional; the explicit button still works.
    });

    button?.addEventListener('click', async () => {
        clearError(errorEl);
        button.disabled = true;

        try {
            const response = await window.Passkeys.verify({
                remember: rememberFromCheckbox(),
            });
            redirectAfterLogin(response);
        } catch (error) {
            if (!isUserCancelled(error)) {
                showError(errorEl, error?.message || 'Unable to sign in with passkey.');
            }
        } finally {
            button.disabled = false;
        }
    });
};

const registerPasskey = async ({ name, submit, modalError, pageError }) => {
    clearError(modalError);
    clearError(pageError);

    submit.disabled = true;

    try {
        await window.Passkeys.register({ name });
        window.location.reload();
    } catch (error) {
        if (isUserCancelled(error)) {
            showError(modalError, 'Passkey creation was cancelled. Try again and complete the browser prompt.');
            return;
        }

        showError(modalError, error?.message || 'Unable to register passkey.');
        showError(pageError, error?.message || 'Unable to register passkey.');
    } finally {
        submit.disabled = false;
    }
};

const initPasskeyManagement = () => {
    const registerRoot = document.querySelector('[data-passkey-register]');
    const unsupported = document.querySelector('[data-passkey-unsupported]');
    const pageError = document.querySelector('[data-passkey-manage-error]');
    const modalError = document.querySelector('[data-passkey-modal-error]');

    if (!registerRoot) {
        return;
    }

    if (!window.Passkeys?.isSupported()) {
        unsupported?.classList.remove('hidden');
        return;
    }

    unsupported?.classList.add('hidden');
    registerRoot.classList.remove('hidden');

    const nameInput = document.querySelector('[data-passkey-name]');
    const submit = document.querySelector('[data-passkey-register-submit]');
    const modal = document.querySelector('dialog[data-modal="register-passkey"]');

    submit?.addEventListener('click', async () => {
        const name = nameInput?.value?.trim();
        if (!name) {
            showError(modalError, 'Please enter a name for this passkey.');
            nameInput?.focus();
            return;
        }

        await registerPasskey({ name, submit, modalError, pageError });
    });

    nameInput?.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            event.preventDefault();
            submit?.click();
        }
    });

    document.querySelectorAll('[data-passkey-delete]').forEach((button) => {
        button.addEventListener('click', async () => {
            clearError(pageError);

            if (!window.confirm('Remove this passkey?')) {
                return;
            }

            const id = button.dataset.passkeyId;
            button.disabled = true;

            try {
                const response = await fetch(`/user/passkeys/${id}`, {
                    method: 'DELETE',
                    headers: csrfHeaders(),
                    credentials: 'same-origin',
                });

                if (!response.ok) {
                    let message = `Request failed with status ${response.status}`;
                    try {
                        const body = await response.json();
                        if (body?.message) {
                            message = body.message;
                        }
                    } catch {
                        // Keep the status message.
                    }
                    throw new Error(message);
                }

                window.location.reload();
            } catch (error) {
                showError(pageError, error?.message || 'Unable to remove passkey.');
                button.disabled = false;
            }
        });
    });

    // Resume after a previous interrupted attempt (name kept in sessionStorage).
    const pendingName = sessionStorage.getItem('passkey.register.name');
    if (pendingName && nameInput && submit && modal) {
        sessionStorage.removeItem('passkey.register.name');
        nameInput.value = pendingName;
        modal.showModal();
        registerPasskey({ name: pendingName, submit, modalError, pageError });
    }
};

document.addEventListener('click', (event) => {
    const openModal = event.target.closest('[data-open-modal]');
    if (openModal) {
        document.querySelector(`dialog[data-modal="${openModal.dataset.openModal}"]`)?.showModal();
        return;
    }

    const closeModal = event.target.closest('[data-close-modal]');
    if (closeModal) {
        document.querySelector(`dialog[data-modal="${closeModal.dataset.closeModal}"]`)?.close();
        return;
    }

    if (event.target.closest('[data-modal-backdrop]')) {
        event.target.closest('dialog')?.close();
    }

    if (event.target.closest('[data-dismiss-banner]')) {
        document.getElementById('app-banner')?.remove();
    }

    const dropdownTrigger = event.target.closest('[data-dropdown-trigger]');
    if (dropdownTrigger) {
        const root = dropdownTrigger.closest('[data-dropdown]');
        root?.querySelector('[data-dropdown-content]')?.classList.toggle('hidden');
        return;
    }

    if (!event.target.closest('[data-dropdown]')) {
        document.querySelectorAll('[data-dropdown-content]').forEach((el) => el.classList.add('hidden'));
    }

    const navToggle = event.target.closest('[data-nav-toggle]');
    if (navToggle) {
        const menu = document.querySelector('[data-nav-menu]');
        menu?.classList.toggle('hidden');
        document.querySelectorAll('[data-nav-icon]').forEach((icon) => icon.classList.toggle('hidden'));
    }

    const toggleRecovery = event.target.closest('[data-toggle-recovery]');
    if (toggleRecovery) {
        const root = toggleRecovery.closest('[data-two-factor-challenge]');
        root?.querySelectorAll('[data-recovery-hide], [data-recovery-show]').forEach((el) => {
            el.classList.toggle('hidden');
        });
        const visible = root?.querySelector('[data-recovery-show]:not(.hidden) input, [data-recovery-hide]:not(.hidden) input');
        visible?.focus();
    }
});

document.addEventListener('DOMContentLoaded', () => {
    initPasskeyLogin();
    initPasskeyManagement();
});
