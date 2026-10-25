@php
    $style = session('flash.bannerStyle', 'success');
    $message = session('flash.banner');
@endphp

@if ($message)
    @php
        $bg = match ($style) {
            'danger' => 'bg-red-700',
            'warning' => 'bg-yellow-500',
            'success' => 'bg-indigo-500',
            default => 'bg-gray-500',
        };
        $iconBg = match ($style) {
            'danger' => 'bg-red-600',
            'warning' => 'bg-yellow-600',
            'success' => 'bg-indigo-600',
            default => 'bg-gray-600',
        };
    @endphp

    <div id="app-banner" class="{{ $bg }}">
        <div class="max-w-screen-xl mx-auto py-2 px-3 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between flex-wrap">
                <div class="w-0 flex-1 flex items-center min-w-0">
                    <span class="flex p-2 rounded-lg {{ $iconBg }}">
                        <svg class="size-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    <p class="ms-3 font-medium text-sm text-white truncate">{{ $message }}</p>
                </div>
                <div class="shrink-0 sm:ms-3">
                    <button type="button" class="-me-1 flex p-2 rounded-md focus:outline-none sm:-me-2 transition hover:bg-black/10" data-dismiss-banner aria-label="Dismiss">
                        <svg class="size-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif
