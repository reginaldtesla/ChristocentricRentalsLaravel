@props([
    'title',
    'description' => '',
    'image',
    'url' => '#',
])

<a href="{{ $url }}" class="category-card group block overflow-hidden rounded border border-gray-200 bg-white transition hover:border-gray-300">
    <div class="flex aspect-[4/3] items-center justify-center bg-gray-50 p-6">
        <img
            src="{{ asset('images/' . $image) }}"
            alt="{{ strip_tags($title) }}"
            class="max-h-full max-w-full object-contain transition duration-300 group-hover:scale-[1.02]"
            loading="lazy"
        >
    </div>
    <div class="border-t border-gray-100 p-4">
        <h3 class="font-medium text-gray-900 group-hover:text-primary">{!! nl2br(e($title)) !!}</h3>
        @if ($description)
            <p class="mt-1 text-sm text-gray-500">{{ $description }}</p>
        @endif
    </div>
</a>
