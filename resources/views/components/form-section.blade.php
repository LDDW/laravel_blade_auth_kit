@props([
    'action',
    'method' => 'POST',
])

@php
    $spoofMethod = ! in_array(strtoupper($method), ['GET', 'POST'], true);
@endphp

<section {{ $attributes->merge(['class' => 'space-y-4']) }}>
    <x-section-title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-section-title>

    <form method="POST" action="{{ $action }}" class="overflow-hidden rounded-xl border bg-card text-card-foreground shadow-sm">
        @csrf
        @if ($spoofMethod)
            @method($method)
        @endif

        <div class="grid grid-cols-6 gap-6 p-6">
            {{ $form }}
        </div>

        @isset($actions)
            <div class="flex items-center justify-end gap-3 border-t bg-muted px-6 py-3">
                {{ $actions }}
            </div>
        @endisset
    </form>
</section>
