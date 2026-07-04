@props(['lists'])

@php
    $titles = [
        'new' => 'New in stock',
        'featured' => 'Staff picks',
        'best_week' => 'Rented often',
        'popular' => 'By category',
    ];
@endphp

<section class="border-t border-gray-200 py-10">
    <div class="container-site">
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($lists as $key => $products)
                <div>
                    <h3 class="mb-3 border-b border-gray-200 pb-2 text-sm font-semibold text-gray-900">
                        {{ $titles[$key] ?? ucwords(str_replace('_', ' ', $key)) }}
                    </h3>
                    <ul class="space-y-2.5">
                        @foreach ($products as $product)
                            <li>
                                <a href="{{ route('shop.show', $product['slug']) }}" class="group block">
                                    <span class="text-sm text-gray-800 group-hover:text-primary">{{ $product['name'] }}</span>
                                    <span class="mt-0.5 block text-sm text-gray-600">{{ \App\Support\ProductCatalog::formatPrice($product['price']) }}/day</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
</section>
