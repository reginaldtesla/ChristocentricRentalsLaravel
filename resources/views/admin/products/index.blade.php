@extends('layouts.admin')

@section('title', 'Products')

@section('content')
    <div class="flex justify-end">
        <a href="{{ route('admin.products.create') }}" class="btn-solid">Add Product</a>
    </div>

    <div class="mt-6 overflow-hidden rounded-xl border border-gray-200 bg-white">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-500">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Category</th>
                    <th class="px-4 py-3">Price/Day</th>
                    <th class="px-4 py-3">Stock</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr class="border-t border-gray-100">
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $product->name }}</td>
                        <td class="px-4 py-3">{{ $product->category?->name ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $product->formattedPrice() }}</td>
                        <td class="px-4 py-3">{{ $product->in_stock ? 'Yes' : 'No' }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-primary hover:underline">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $products->links() }}</div>
@endsection
