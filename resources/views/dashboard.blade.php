<x-app-layout>
    <x-slot name="header">
        <h1 class="truncate text-sm font-semibold tracking-tight">
            {{ __('Dashboard') }}
        </h1>
    </x-slot>

    <div class="mx-auto w-full max-w-3xl">
        <div class="rounded-xl border bg-card p-6 text-card-foreground shadow-sm">
            <h2 class="text-lg font-semibold tracking-tight">{{ __('Welcome!') }}</h2>
            <p class="mt-1.5 text-sm text-muted-foreground">{{ __('You are logged in.') }}</p>
        </div>
    </div>
</x-app-layout>
