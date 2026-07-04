@props(['tabs', 'panels'])

<section class="home-section container-site" data-product-tabs data-tab-style="pill">
    <x-section-title title="From the catalog" />

    <div class="mb-5 flex flex-wrap gap-2">
        @foreach ($tabs as $key => $label)
            <button
                type="button"
                data-tab-trigger="{{ $key }}"
                class="tab-trigger rounded border px-3 py-1.5 text-sm font-medium transition {{ $loop->first ? 'border-gray-900 bg-gray-900 text-white' : 'border-gray-200 bg-white text-gray-600 hover:border-gray-300' }}"
            >
                {{ $label }}
            </button>
        @endforeach
    </div>

    @foreach ($panels as $key => $products)
        <div data-tab-panel="{{ $key }}" class="{{ $loop->first ? '' : 'hidden' }}">
            <div class="grid grid-cols-2 gap-3 sm:gap-4 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6">
                @foreach ($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>
    @endforeach
</section>
