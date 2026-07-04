@props([
    'title',
    'description' => '',
    'image',
    'url' => '#',
])

<a href="{{ $url }}" class="spotlight-card group flex flex-col overflow-hidden rounded border border-gray-200 bg-white transition hover:border-gray-300">
    <div class="flex aspect-square items-center justify-center bg-gray-50 p-5">
        <img src="{{ asset('images/' . $image) }}" alt="{{ $title }}" class="max-h-full max-w-full object-contain" loading="lazy">
    </div>
    <div class="flex flex-1 flex-col p-4">
        <h3 class="font-medium text-gray-900">{{ $title }}</h3>
        @if ($description)
            <p class="mt-1 text-sm text-gray-500">{{ $description }}</p>
        @endif
        <span class="mt-auto pt-3 text-sm text-primary">View gear</span>
    </div>
</a>
