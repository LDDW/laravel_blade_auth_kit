@props([
    'name',
    'maxWidth' => '2xl',
])

<x-modal :name="$name" :max-width="$maxWidth" {{ $attributes }}>
    <div class="px-6 py-4">
        <div class="text-base font-semibold tracking-tight">
            {{ $title }}
        </div>

        <div class="mt-2 text-sm text-muted-foreground">
            {{ $content }}
        </div>
    </div>

    <div class="flex flex-row justify-end gap-2 border-t px-6 py-4">
        {{ $footer }}
    </div>
</x-modal>
