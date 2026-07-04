@extends('layouts.app')

@section('title', 'Compare Products — ' . config('app.name'))

@section('content')
    <x-pages.hero title="Compare products" subtitle="Side-by-side specs to help you pick the right gear." />

    <div class="container-site py-10">
        @if ($products->isEmpty())
            <div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-12 text-center">
                <p class="text-gray-600">No products to compare yet.</p>
                <p class="mt-2 text-sm text-gray-500">Browse the shop and click <strong>Add to compare</strong> on up to {{ $maxItems }} items.</p>
                <a href="{{ route('shop') }}" class="btn-solid mt-6">Browse gear</a>
            </div>
        @else
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <p class="text-sm text-gray-600">{{ $products->count() }} of {{ $maxItems }} products selected</p>
                <form action="{{ route('compare.clear') }}" method="POST" onsubmit="return confirm('Clear your compare list?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm text-red-600 hover:underline">Clear all</button>
                </form>
            </div>

            <div class="compare-table-wrap overflow-x-auto rounded-2xl border border-gray-200 bg-white">
                <table class="compare-table min-w-full text-sm">
                    <thead>
                        <tr>
                            <th class="compare-table-label"></th>
                            @foreach ($products as $product)
                                <th class="compare-table-product">
                                    <div class="compare-table-product-inner">
                                        <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="compare-table-image">
                                        <h2 class="compare-table-name">{{ $product->name }}</h2>
                                        <form action="{{ route('compare.destroy', $product->slug) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-gray-500 hover:text-red-600">Remove</button>
                                        </form>
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row" class="compare-table-label">Daily rate</th>
                            @foreach ($products as $product)
                                <td class="compare-table-value font-semibold text-gray-900">{{ $product->formattedPrice() }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <th scope="row" class="compare-table-label">Category</th>
                            @foreach ($products as $product)
                                <td class="compare-table-value">{{ $product->category?->name ?? '—' }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <th scope="row" class="compare-table-label">Availability</th>
                            @foreach ($products as $product)
                                <td class="compare-table-value">
                                    @if ($product->in_stock)
                                        <span class="text-green-700">In stock</span>
                                        @if ($product->quantity > 1)
                                            <span class="text-gray-500">({{ $product->quantity }} units)</span>
                                        @endif
                                    @else
                                        <span class="text-red-600">Unavailable</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <th scope="row" class="compare-table-label">Rating</th>
                            @foreach ($products as $product)
                                <td class="compare-table-value">{{ $product->rating ? $product->rating.'/5' : '—' }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <th scope="row" class="compare-table-label">Highlights</th>
                            @foreach ($products as $product)
                                <td class="compare-table-value">
                                    <ul class="compare-table-tags">
                                        @if ($product->is_new)
                                            <li>New</li>
                                        @endif
                                        @if ($product->is_featured)
                                            <li>Featured</li>
                                        @endif
                                        @if (! $product->is_new && ! $product->is_featured)
                                            <li>—</li>
                                        @endif
                                    </ul>
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <th scope="row" class="compare-table-label">Summary</th>
                            @foreach ($products as $product)
                                <td class="compare-table-value text-gray-600">{{ $product->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($product->description ?? ''), 160) ?: '—' }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <th scope="row" class="compare-table-label"></th>
                            @foreach ($products as $product)
                                <td class="compare-table-value">
                                    <a href="{{ route('shop.show', $product) }}" class="btn-solid inline-block px-4 py-2 text-sm">
                                        {{ $product->in_stock ? 'Rent this' : 'View details' }}
                                    </a>
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>

            @if ($products->count() < $maxItems)
                <p class="mt-6 text-center text-sm text-gray-500">
                    You can add {{ $maxItems - $products->count() }} more product{{ ($maxItems - $products->count()) === 1 ? '' : 's' }}.
                    <a href="{{ route('shop') }}" class="font-medium text-primary hover:underline">Continue shopping</a>
                </p>
            @endif
        @endif
    </div>
@endsection
