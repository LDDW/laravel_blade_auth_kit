import './bootstrap';

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
