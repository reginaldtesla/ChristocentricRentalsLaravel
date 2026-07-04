@props(['features'])

<section class="border-b border-gray-200 bg-gray-50">
    <div class="container-site">
        <ul class="flex flex-wrap items-center justify-center gap-x-6 gap-y-2 py-3 text-xs text-gray-600 md:gap-x-10 md:text-sm">
            @foreach ($features as $feature)
                <li class="flex items-center gap-2">
                    <span class="h-1 w-1 shrink-0 rounded-full bg-primary"></span>
                    <span><strong class="font-medium text-gray-800">{{ $feature['title'] }}</strong> — {{ $feature['subtitle'] }}</span>
                </li>
            @endforeach
        </ul>
    </div>
</section>
