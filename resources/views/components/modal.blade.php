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
    class="z-50 m-0 min-h-full min-w-full overflow-y-auto bg-transparent backdrop:bg-transparent p-0 open:flex open:items-start open:justify-center"
>
    <div class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50">
        <div data-modal-backdrop class="fixed inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>

        <div class="relative mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto {{ $maxWidthClass }}">
            {{ $slot }}
        </div>
    </div>
</dialog>
