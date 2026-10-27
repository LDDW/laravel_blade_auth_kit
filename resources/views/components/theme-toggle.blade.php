<div
    x-data="themeToggle"
    class="inline-flex items-center rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 p-0.5"
    role="group"
    aria-label="{{ __('Theme') }}"
>
    <button
        type="button"
        @click="set('light')"
        :class="theme === 'light' ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100' : 'text-gray-500 dark:text-gray-400'"
        class="rounded px-2 py-1 text-xs font-medium transition"
    >
        {{ __('Light') }}
    </button>
    <button
        type="button"
        @click="set('dark')"
        :class="theme === 'dark' ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100' : 'text-gray-500 dark:text-gray-400'"
        class="rounded px-2 py-1 text-xs font-medium transition"
    >
        {{ __('Dark') }}
    </button>
    <button
        type="button"
        @click="set('system')"
        :class="theme === 'system' ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100' : 'text-gray-500 dark:text-gray-400'"
        class="rounded px-2 py-1 text-xs font-medium transition"
    >
        {{ __('System') }}
    </button>
</div>
