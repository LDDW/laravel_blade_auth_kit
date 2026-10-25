@props(['on'])

@if (session('status') === $on)
    <div {{ $attributes->merge(['class' => 'text-sm text-gray-600 dark:text-gray-400']) }}>
        {{ $slot->isEmpty() ? __('Saved.') : $slot }}
    </div>
@endif
