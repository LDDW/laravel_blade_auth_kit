<div class="flex min-h-svh flex-col bg-muted px-4">
    <div class="m-auto w-full max-w-sm py-10">
        <div class="rounded-xl border bg-card text-card-foreground shadow-sm">
            <div class="flex flex-col gap-6 p-6">
                <div class="flex flex-col items-center gap-2 text-center">
                    @isset($logo)
                        {{ $logo }}
                    @else
                        <x-authentication-card-logo />
                    @endisset

                    @isset($title)
                        <h1 class="text-2xl font-semibold tracking-tight">{{ $title }}</h1>
                    @endisset

                    @isset($description)
                        <p class="text-sm text-balance text-muted-foreground">{{ $description }}</p>
                    @endisset
                </div>

                {{ $slot }}

                @isset($footer)
                    <p class="text-center text-sm text-muted-foreground">{{ $footer }}</p>
                @endisset
            </div>
        </div>
    </div>
</div>
