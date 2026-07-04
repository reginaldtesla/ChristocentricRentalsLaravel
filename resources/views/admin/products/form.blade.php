@extends('layouts.admin')

@section('title', $product->exists ? 'Edit Product' : 'Add Product')

@section('content')
    <form action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="max-w-2xl space-y-4 rounded-xl border border-gray-200 bg-white p-6">
        @csrf
        @if ($product->exists) @method('PUT') @endif

        <div>
            <label class="mb-1 block text-sm font-medium">Name</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium">Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $product->slug) }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium">Category</label>
            <select name="category_id" class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">
                <option value="">— None —</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium">Price per day (₵)</label>
            <input type="number" step="0.01" name="price_per_day" value="{{ old('price_per_day', $product->price_per_day) }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">
        </div>
        <x-admin-image-upload
            name="image"
            :value="old('image', $product->image)"
            label="Product photo"
        />
        <div>
            <label class="mb-1 block text-sm font-medium">Excerpt</label>
            <textarea name="excerpt" rows="2" class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">{{ old('excerpt', $product->excerpt) }}</textarea>
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium">Description</label>
            <textarea name="description" rows="5" class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">{{ old('description', $product->description) }}</textarea>
        </div>
        <div class="flex flex-wrap gap-4">
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_new" value="1" @checked(old('is_new', $product->is_new))> New</label>
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured))> Featured</label>
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="in_stock" value="1" @checked(old('in_stock', $product->in_stock ?? true))> In stock</label>
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium">Units available</label>
            <p class="mb-2 text-xs text-gray-500">How many of this item you have to rent at the same time (e.g. 2 if you own two identical cameras).</p>
            <input type="number" name="quantity" min="0" max="999" value="{{ old('quantity', $product->quantity ?? 1) }}" required class="w-24 rounded-lg border border-gray-300 px-4 py-2 text-sm">
            @error('quantity')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium">Rating (1-5)</label>
            <input type="number" name="rating" min="1" max="5" value="{{ old('rating', $product->rating ?? 4) }}" class="w-24 rounded-lg border border-gray-300 px-4 py-2 text-sm">
        </div>
        <button type="submit" class="btn-solid">Save Product</button>
    </form>
@endsection
