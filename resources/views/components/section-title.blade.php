<div class="flex items-start justify-between gap-4">
    <div>
        <h3 class="text-base font-medium tracking-tight">{{ $title }}</h3>

        <p class="mt-1 text-sm text-muted-foreground">
            {{ $description }}
        </p>
    </div>

    <div>
        {{ $aside ?? '' }}
    </div>
</div>
