<section class="border-b border-gray-200 py-10">
    <div class="container-site text-center">
        <p class="mb-5 text-sm text-gray-500">Brands in our inventory</p>
        <div class="flex flex-wrap items-center justify-center gap-x-8 gap-y-3">
            @foreach (array_slice(config('site.brands'), 0, 8) as $brand)
                <a href="{{ route('shop', ['q' => $brand]) }}" class="text-sm font-medium text-gray-700 transition hover:text-primary">
                    {{ $brand }}
                </a>
            @endforeach
        </div>
    </div>
</section>
