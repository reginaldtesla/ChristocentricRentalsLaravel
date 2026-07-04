@extends('layouts.app')

@section('title', 'Shop — ' . config('app.name'))

@section('content')
    <div class="border-b border-gray-200 bg-gray-50">
        <div class="container-site py-6">
            <h1 class="text-2xl font-semibold text-gray-900">Shop</h1>
            <p class="mt-1 text-sm text-gray-600">Cameras, lenses, lighting, audio and accessories available to rent.</p>
        </div>
    </div>

    <div class="container-site py-10">
        <div class="flex flex-col gap-8 lg:flex-row">
            <aside class="lg:w-56 shrink-0">
                <h2 class="mb-3 text-sm font-semibold text-gray-900">Categories</h2>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('shop') }}" class="block rounded-lg px-3 py-2 text-sm {{ empty($activeCategory) ? 'bg-primary-light font-medium text-primary' : 'text-gray-700 hover:bg-gray-100' }}">
                            All Products
                        </a>
                    </li>
                    @foreach ($siteCategories as $category)
                        <li>
                            <a href="{{ route('shop', ['category' => $category['slug']]) }}" class="block rounded-lg px-3 py-2 text-sm {{ $activeCategory === $category['slug'] ? 'bg-primary-light font-medium text-primary' : 'text-gray-700 hover:bg-gray-100' }}">
                                {{ $category['name'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </aside>

            <div class="flex-1">
                @if (count($products) === 0)
                    <div class="rounded border border-dashed border-gray-300 bg-gray-50 p-10 text-center">
                        <p class="text-gray-600">Nothing in this category yet.</p>
                        <a href="{{ route('shop') }}" class="mt-3 inline-block text-sm text-primary hover:underline">Back to all products</a>
                    </div>
                @else
                    <p class="mb-6 text-sm text-gray-500">{{ count($products) }} product{{ count($products) === 1 ? '' : 's' }}</p>
                    <div class="grid grid-cols-2 gap-4 md:grid-cols-3 xl:grid-cols-4 lg:gap-6">
                        @foreach ($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
