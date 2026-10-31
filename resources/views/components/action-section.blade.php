<section {{ $attributes->merge(['class' => 'space-y-4']) }}>
    <x-section-title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-section-title>

    <div class="rounded-xl border bg-card p-6 text-card-foreground shadow-sm">
        {{ $content }}
    </div>
</section>
