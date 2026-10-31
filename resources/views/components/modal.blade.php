@props([
    'name',
    'maxWidth' => '2xl',
])

@php
$maxWidthClass = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
][$maxWidth];
@endphp

<dialog
    data-modal="{{ $name }}"
    class="m-0 h-dvh max-h-none w-full max-w-none border-0 bg-transparent p-0 backdrop:bg-transparent"
>
    <div data-modal-backdrop class="flex min-h-full items-center justify-center bg-black/80 p-4">
        <div data-modal-panel class="w-full {{ $maxWidthClass }} overflow-hidden rounded-xl border bg-card text-card-foreground shadow-lg">
            {{ $slot }}
        </div>
    </div>
</dialog>
