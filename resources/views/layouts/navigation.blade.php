<aside
    id="app-sidebar"
    data-nav-menu
    class="fixed inset-y-0 start-0 z-50 flex w-64 -translate-x-full flex-col border-e border-sidebar-border bg-sidebar text-sidebar-foreground transition-transform duration-200 sidebar-open:translate-x-0 md:translate-x-0"
    aria-label="{{ __('Navigation') }}"
>
    <div class="flex h-14 items-center justify-between gap-2 border-b border-sidebar-border px-4">
        <a href="{{ route('dashboard') }}" class="flex min-w-0 items-center gap-2 font-semibold tracking-tight" data-nav-close>
            <x-application-mark class="size-7 shrink-0" />
            <span class="truncate">{{ config('app.name', 'Laravel') }}</span>
        </a>

        <button
            type="button"
            class="inline-flex size-8 items-center justify-center rounded-md hover:bg-sidebar-accent md:hidden"
            data-nav-close
            aria-label="{{ __('Close menu') }}"
        >
            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <nav class="flex flex-1 flex-col gap-1 p-3">
        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" data-nav-close>
            <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
            </svg>
            {{ __('Dashboard') }}
        </x-nav-link>
    </nav>

    <div class="border-t border-sidebar-border p-3">
        <div class="relative" x-data="{ open: false }" @click.outside="open = false" @keydown.escape.window="open = false">
            <button
                type="button"
                @click="open = !open"
                :aria-expanded="open"
                aria-haspopup="menu"
                class="flex w-full items-center gap-3 rounded-md px-2 py-2 text-start transition-colors hover:bg-sidebar-accent"
            >
                <span class="flex size-8 shrink-0 items-center justify-center rounded-full bg-sidebar-accent text-xs font-medium">
                    {{ strtoupper(mb_substr(Auth::user()->name, 0, 1)) }}
                </span>
                <span class="min-w-0 flex-1">
                    <span class="block truncate text-sm font-medium">{{ Auth::user()->name }}</span>
                    <span class="block truncate text-xs text-muted-foreground">{{ Auth::user()->email }}</span>
                </span>
                <svg class="size-4 shrink-0 text-muted-foreground" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                </svg>
            </button>

            <div
                x-cloak
                x-show="open"
                role="menu"
                class="absolute inset-x-0 bottom-full z-50 mb-1 rounded-md border bg-popover p-1 text-popover-foreground shadow-md"
            >
                <a href="{{ route('profile.show') }}" role="menuitem" data-nav-close class="flex items-center gap-2 rounded-sm px-2 py-1.5 text-sm hover:bg-accent">
                    <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    {{ __('Profile') }}
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" role="menuitem" class="flex w-full items-center gap-2 rounded-sm px-2 py-1.5 text-sm hover:bg-accent">
                        <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                        </svg>
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>
