@props(['product', 'showExcerpt' => false, 'showRentButton' => false])

@php
    $slug = is_array($product) ? ($product['slug'] ?? null) : $product->slug;
    $url = $slug ? route('shop.show', $slug) : route('shop');
    $name = is_array($product) ? $product['name'] : $product->name;
    $imagePath = is_array($product)
        ? \App\Support\ProductImage::pathForSlug($slug, $product['image'] ?? null)
        : $product->imageSourcePath();
    $cardImage = \App\Support\ProductImage::url($imagePath, \App\Support\ProductImage::SIZE_CARD);
    $category = is_array($product) ? ($product['category'] ?? null) : $product->category?->name;
    $price = is_array($product) ? $product['price'] : (float) $product->price_per_day;
    $excerpt = is_array($product) ? ($product['excerpt'] ?? null) : $product->excerpt;
    $isNew = is_array($product) ? ($product['is_new'] ?? false) : $product->is_new;
    $inStock = is_array($product) ? ($product['in_stock'] ?? true) : $product->in_stock;
    $formattedPrice = is_array($product)
        ? \App\Support\ProductCatalog::formatPrice($price)
        : $product->formattedPrice();
    $productId = is_array($product) ? ($product['id'] ?? null) : $product->id;
@endphp

<article class="product-card group relative flex flex-col overflow-hidden transition hover:border-gray-300">
    <a href="{{ $url }}" class="product-card-media relative">
        <img
            src="{{ $cardImage }}"
            alt="{{ $name }}"
            class="product-card-image"
            loading="lazy"
        >
        @if ($isNew)
            <span class="absolute left-2 top-2 bg-gray-900 px-1.5 py-0.5 text-[10px] font-medium uppercase text-white">New</span>
        @endif
    </a>
    @if ($slug && $productId)
        <div class="absolute right-2 top-2 z-10">
            <x-compare-button :slug="$slug" :product-id="$productId" compact />
        </div>
    @endif
    <div class="flex flex-1 flex-col border-t border-gray-100 p-3">
        @if ($category)
            <p class="mb-0.5 text-xs text-gray-500">{{ $category }}</p>
        @endif
        <h3 class="mb-2 line-clamp-2 text-sm leading-snug text-gray-900">
            <a href="{{ $url }}" class="hover:text-primary">{{ $name }}</a>
        </h3>
        @if ($showExcerpt && $excerpt)
            <p class="mb-2 line-clamp-2 text-xs text-gray-500">{{ $excerpt }}</p>
        @endif
        <div class="mt-auto space-y-2">
            <p class="text-sm font-semibold text-gray-900">
                {{ $formattedPrice }}<span class="font-normal text-gray-500">/day</span>
            </p>
            @if ($showRentButton)
                <a href="{{ $url }}" class="text-sm font-medium text-gray-900 underline-offset-2 hover:text-primary hover:underline">
                    View details
                </a>
            @elseif (! $inStock)
                <span class="text-xs text-red-600">Unavailable</span>
            @endif
        </div>
    </div>
</article>
