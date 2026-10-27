import Alpine from 'alpinejs';

Alpine.data('themeToggle', () => ({
    theme: document.documentElement.dataset.theme || 'system',

    set(value) {
        this.theme = value;
        document.cookie = `theme=${value}; path=/; max-age=31536000; SameSite=Lax`;
        document.documentElement.dataset.theme = value;

        const dark = value === 'dark'
            || (value === 'system' && matchMedia('(prefers-color-scheme: dark)').matches);

        document.documentElement.classList.toggle('dark', dark);
    },
}));

window.Alpine = Alpine;
Alpine.start();
