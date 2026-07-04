@props(['title', 'link' => null, 'linkText' => 'View all', 'linkMobile' => null, 'size' => 'default'])

<div class="home-section-head">
    <h2 @class([
        'font-semibold tracking-tight text-gray-900',
        'text-xl md:text-2xl' => $size === 'large',
        'text-lg md:text-xl' => $size === 'default',
    ])>{{ $title }}</h2>
    @if ($link)
        <a href="{{ $link }}" class="text-sm text-gray-500 transition hover:text-primary">
            <span class="md:hidden">{{ $linkMobile ?? $linkText }}</span>
            <span class="hidden md:inline">{{ $linkText }}</span>
        </a>
    @endif
</div>
