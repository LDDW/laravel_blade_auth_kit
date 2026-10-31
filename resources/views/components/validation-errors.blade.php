@if ($errors->any())
    <div {{ $attributes->merge(['class' => 'rounded-lg border border-destructive/30 bg-destructive/10 px-3 py-2 text-sm text-destructive']) }}>
        <p class="font-medium">{{ __('Whoops! Something went wrong.') }}</p>

        <ul class="mt-2 list-disc space-y-1 ps-4">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
