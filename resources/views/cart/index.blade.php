@extends('layouts.app')

@section('title', 'Cart — ' . config('app.name'))

@section('content')
    <x-pages.hero title="Your Cart" subtitle="Review your rental items before checkout." />

    <div class="container-site py-10">
        @if (count($items) === 0)
            <div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-12 text-center">
                <p class="text-gray-600">Your cart is empty.</p>
                <a href="{{ route('shop') }}" class="btn-solid mt-6">Browse Gear</a>
            </div>
        @else
            <div class="grid gap-8 lg:grid-cols-3">
                <div class="space-y-4 lg:col-span-2">
                    @foreach ($items as $item)
                        <div class="flex flex-col gap-4 rounded-2xl border border-gray-200 bg-white p-4 sm:flex-row sm:items-center">
                            <img src="{{ \App\Support\ProductImage::url($item['image'], \App\Support\ProductImage::SIZE_THUMB) }}" alt="" class="h-24 w-24 shrink-0 rounded-lg object-contain">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900">
                                    <a href="{{ route('shop.show', $item['slug']) }}" class="hover:text-primary">{{ $item['name'] }}</a>
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">{{ \App\Services\RentalPricing::format($item['price_per_day']) }}/day × {{ $item['days'] }} day(s) × {{ $item['quantity'] }}</p>
                                <p class="text-sm text-gray-600">{{ \App\Services\RentalPricing::formatScheduleRange($item['rental_start'], $item['pickup_time'] ?? null, $item['rental_end'], $item['return_time'] ?? null) }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-gray-900">{{ \App\Services\RentalPricing::format($item['line_total']) }}</p>
                                <form action="{{ route('cart.destroy', $item['key']) }}" method="POST" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-600 hover:underline">Remove</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="rounded-2xl border border-gray-200 bg-gray-50 p-6 lg:sticky lg:top-28 lg:self-start">
                    <h2 class="text-lg font-semibold text-gray-900">Order Summary</h2>
                    <div class="mt-4 flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span class="font-semibold text-gray-900">{{ \App\Services\RentalPricing::format($subtotal) }}</span>
                    </div>
                    <p class="mt-2 text-xs text-gray-500">All bookings must be paid in full before confirmation.</p>
                    @guest
                        <p class="mt-3 rounded-lg bg-primary-light px-3 py-2 text-xs text-gray-700">
                            You'll need to <a href="{{ route('login') }}" class="font-semibold text-primary hover:underline">sign in</a> or <a href="{{ route('register') }}" class="font-semibold text-primary hover:underline">register</a> to complete checkout.
                        </p>
                    @endguest
                    <a href="{{ route('checkout.index') }}" class="btn-solid mt-6 block w-full py-3 text-center">Proceed to Checkout</a>
                    <a href="{{ route('shop') }}" class="mt-3 block text-center text-sm text-primary hover:underline">Continue shopping</a>
                </div>
            </div>
        @endif
    </div>
@endsection
