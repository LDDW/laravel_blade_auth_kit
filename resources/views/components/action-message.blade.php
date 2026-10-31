@props(['on'])

@if (session('status') === $on)
    <div {{ $attributes->merge(['class' => 'text-sm text-muted-foreground']) }}>
        {{ $slot->isEmpty() ? __('Saved.') : $slot }}
    </div>
@endif
