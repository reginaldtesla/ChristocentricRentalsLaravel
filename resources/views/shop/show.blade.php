@extends('layouts.app')

@section('title', $product->name . ' — ' . config('app.name'))

@section('content')
    <div class="container-site py-6">
        <nav class="text-sm text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-primary">Home</a>
            <span class="mx-2">/</span>
            <a href="{{ route('shop') }}" class="hover:text-primary">Shop</a>
            @if ($product->category)
                <span class="mx-2">/</span>
                <a href="{{ route('shop', ['category' => $product->category->slug]) }}" class="hover:text-primary">{{ $product->category->name }}</a>
            @endif
            <span class="mx-2">/</span>
            <span class="text-gray-800">{{ $product->name }}</span>
        </nav>
    </div>

    <div class="container-site pb-12">
        @if ($prevProduct || $nextProduct)
            <div class="mb-6 flex justify-between gap-4 text-sm">
                @if ($prevProduct)
                    <a href="{{ route('shop.show', $prevProduct) }}" class="flex max-w-[45%] items-center gap-2 text-gray-600 hover:text-primary">
                        <span aria-hidden="true">←</span>
                        <span class="truncate">{{ $prevProduct->name }}</span>
                    </a>
                @else
                    <span></span>
                @endif
                @if ($nextProduct)
                    <a href="{{ route('shop.show', $nextProduct) }}" class="flex max-w-[45%] items-center gap-2 text-right text-gray-600 hover:text-primary">
                        <span class="truncate">{{ $nextProduct->name }}</span>
                        <span aria-hidden="true">→</span>
                    </a>
                @endif
            </div>
        @endif

        <div class="grid gap-10 lg:grid-cols-2 lg:gap-14">
            {{-- Gallery --}}
            <div>
                <div class="overflow-hidden rounded border border-gray-200 bg-white p-6 lg:p-8">
                    @php($galleryDimensions = $product->image ? \App\Support\ProductImage::intrinsicDimensions($product->imageSourcePath()) : null)
                    <img
                        src="{{ $product->galleryImageUrl() }}"
                        @if ($product->imageSrcset())
                            srcset="{{ collect($product->imageSrcset())->map(fn ($item) => asset('images/'.$item['path']).' '.$item['width'].'w')->implode(', ') }}"
                            sizes="(min-width: 1024px) 640px, 100vw"
                        @endif
                        @if ($galleryDimensions)
                            width="{{ $galleryDimensions['width'] }}"
                            height="{{ $galleryDimensions['height'] }}"
                        @endif
                        alt="{{ $product->name }}"
                        class="product-gallery-image"
                    >
                </div>
            </div>

            {{-- Summary + booking --}}
            <div>
                @if ($product->category)
                    <p class="text-sm text-gray-500">{{ $product->category->name }}</p>
                @endif

                <div class="mt-1 flex flex-wrap items-start justify-between gap-3">
                    <h1 class="text-2xl font-semibold text-gray-900 md:text-3xl">{{ $product->name }}</h1>
                    <x-compare-button :slug="$product->slug" :product-id="$product->id" />
                </div>

                <p class="mt-3 text-2xl font-semibold text-gray-900">
                    {{ $product->formattedPrice() }}<span class="text-base font-normal text-gray-500">/day</span>
                </p>

                @if ($product->in_stock)
                    <p class="mt-2 text-sm text-green-700" data-rental-stock-label>Available to rent — pick dates below</p>
                @else
                    <p class="mt-2 text-sm text-gray-500">Currently unavailable</p>
                @endif

                <div class="mt-5 border border-gray-200 bg-gray-50 p-4 text-sm text-gray-600">
                    <p>Rental is charged per day. Choose your pickup and return dates and times below to see the total.</p>
                </div>

                @if ($product->in_stock)
                    <form action="{{ route('cart.store') }}" method="POST" class="mt-6 space-y-5" data-rental-form data-product-id="{{ $product->id }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="price_per_day" value="{{ $product->price_per_day }}" data-price-per-day>

                        <div>
                            <label for="rental_start" class="mb-1.5 block text-sm font-semibold text-gray-900">Pickup & return schedule</label>
                            <x-rental-datetime-fields
                                :pickup-time="old('pickup_time', config('site.rental_defaults.pickup_time'))"
                                :return-time="old('return_time', config('site.rental_defaults.return_time'))"
                            />
                        </div>

                        <div>
                            <label for="quantity" class="mb-1.5 block text-sm font-semibold text-gray-900">Quantity</label>
                            <input
                                type="number"
                                id="quantity"
                                name="quantity"
                                value="{{ old('quantity', 1) }}"
                                min="1"
                                max="{{ $maxQuantity }}"
                                class="w-24 rounded border border-gray-300 px-3 py-2.5 text-sm"
                                data-rental-qty
                            >
                        </div>

                        <div
                            class="rental-availability hidden rounded-lg border px-4 py-3 text-sm"
                            data-rental-availability
                            role="status"
                            aria-live="polite"
                        ></div>

                        <div class="border border-gray-200 p-4 text-sm">
                            <div class="flex justify-between text-gray-600">
                                <span>Rental period</span>
                                <span data-rental-days>—</span>
                            </div>
                            <div class="mt-2 flex justify-between text-lg font-bold text-gray-900">
                                <span>Estimated total</span>
                                <span data-rental-total>—</span>
                            </div>
                        </div>

                        <button type="submit" class="btn-solid w-full py-3" data-rental-submit>Add to cart</button>
                    </form>
                @endif

                <div class="mt-6 border-t border-gray-200 pt-6 text-sm text-gray-600">
                    <p><span class="font-semibold text-gray-900">Category:</span> {{ $product->category?->name ?? 'General' }}</p>
                </div>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="mt-14 product-detail-tabs" data-product-tabs data-tab-style="underline">
            <div class="flex gap-1 border-b border-gray-200">
                <button type="button" data-tab-trigger="description" class="tab-trigger tab-trigger--active">Description</button>
                <button type="button" data-tab-trigger="shipping" class="tab-trigger">Shipping &amp; Delivery</button>
                <button type="button" data-tab-trigger="policy" class="tab-trigger">Rental Policy</button>
            </div>

            <div data-tab-panel="description" class="py-8">
                @if ($product->description || $product->excerpt)
                    <div class="prose max-w-none text-gray-600">
                        {!! nl2br(e($product->description ?: $product->excerpt)) !!}
                    </div>
                @else
                    <p class="text-gray-600">Professional rental gear available for pickup in Accra. Contact us if you need help choosing the right equipment.</p>
                @endif
            </div>

            <div data-tab-panel="shipping" class="hidden py-8">
                <div class="max-w-2xl space-y-3 text-sm text-gray-600">
                    <p class="font-semibold text-gray-900">Delivery &amp; pickup</p>
                    <p>Delivery may be available for returning clients. First-time clients are required to pick up orders in person with a valid Ghana Card.</p>
                    <p>All bookings must be paid in full before they are confirmed.</p>
                </div>
            </div>

            <div data-tab-panel="policy" class="hidden py-8">
                <ul class="max-w-2xl list-disc space-y-2 pl-5 text-sm text-gray-600">
                    <li>Account required to complete checkout.</li>
                    <li>The account holder must be present at pickup with valid ID.</li>
                    <li>Cancellations may incur fees depending on how close they are to the rental date.</li>
                    <li>Payment is required before your booking is confirmed.</li>
                </ul>
            </div>
        </div>

        @if ($related->isNotEmpty())
            <div class="mt-14 border-t border-gray-200 pt-12">
                <h2 class="mb-6 text-xl font-bold text-gray-900">Related products</h2>
                <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                    @foreach ($related as $item)
                        <x-product-card :product="$item" />
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
