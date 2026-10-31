@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'bg-popover text-popover-foreground'])

@php
$alignmentClasses = match ($align) {
    'left' => 'ltr:origin-top-left rtl:origin-top-right start-0',
    'top' => 'origin-top',
    default => 'ltr:origin-top-right rtl:origin-top-left end-0',
};

$widthClass = match ((string) $width) {
    '60' => 'w-60',
    default => 'w-48',
};
@endphp

<div class="relative" data-dropdown>
    <div data-dropdown-trigger>
        {{ $trigger }}
    </div>

    <div data-dropdown-content class="hidden absolute z-50 mt-2 {{ $widthClass }} rounded-md border shadow-md {{ $alignmentClasses }} {{ $contentClasses }}">
        <div class="py-1">
            {{ $content }}
        </div>
    </div>
</div>
