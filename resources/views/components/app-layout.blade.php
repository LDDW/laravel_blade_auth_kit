@php
    $theme = request()->cookie('theme', 'system');
    if (! in_array($theme, ['light', 'dark', 'system'], true)) {
        $theme = 'system';
    }
@endphp
<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="{{ $theme === 'dark' ? 'dark' : '' }}"
    data-theme="{{ $theme }}"
>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? $title.' — ' : '' }}{{ config('app.name', 'Laravel') }}</title>

        <script>
            if (document.documentElement.dataset.theme === 'system' &&
                matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.classList.add('dark');
            }
        </script>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <x-banner />

        <div data-shell class="min-h-svh">
            <div
                data-nav-overlay
                data-nav-close
                class="fixed inset-0 z-40 bg-black/50 opacity-0 pointer-events-none transition-opacity sidebar-open:pointer-events-auto sidebar-open:opacity-100 md:hidden"
            ></div>

            @include('layouts.navigation')

            <div class="flex min-h-svh flex-col md:ps-64">
                <header class="sticky top-0 z-30 flex h-14 items-center gap-3 border-b bg-background px-4 md:px-6">
                    <button
                        type="button"
                        data-nav-toggle
                        class="inline-flex size-9 items-center justify-center rounded-md hover:bg-accent md:hidden"
                        aria-expanded="false"
                        aria-controls="app-sidebar"
                        aria-label="{{ __('Open menu') }}"
                    >
                        <svg class="size-5 sidebar-open:hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <svg class="hidden size-5 sidebar-open:block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>

                    @isset($header)
                        <div class="min-w-0 flex-1">
                            {{ $header }}
                        </div>
                    @else
                        <div class="flex-1"></div>
                    @endisset

                    <x-theme-toggle />
                </header>

                <main class="flex-1 p-4 md:p-8">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
