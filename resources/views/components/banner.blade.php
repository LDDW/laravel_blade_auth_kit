@php
    $style = session('flash.bannerStyle', 'success');
    $message = session('flash.banner');
@endphp

@if ($message)
    @php
        $classes = match ($style) {
            'danger' => 'border-destructive/30 bg-destructive/10 text-destructive',
            'warning' => 'border-amber-500/30 bg-amber-500/10 text-amber-800 dark:text-amber-200',
            default => 'border-border bg-muted text-foreground',
        };
    @endphp

    <div id="app-banner" class="border-b {{ $classes }}">
        <div class="flex items-center justify-between gap-3 px-4 py-2.5 sm:px-6">
            <p class="min-w-0 truncate text-sm font-medium">{{ $message }}</p>
            <button type="button" class="rounded-md p-1 hover:bg-foreground/5" data-dismiss-banner aria-label="{{ __('Dismiss') }}">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
@endif
