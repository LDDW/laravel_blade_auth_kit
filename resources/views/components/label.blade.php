@props(['value'])

<label {{ $attributes->merge(['class' => 'text-sm font-medium leading-none']) }}>
    {{ $value ?? $slot }}
</label>
