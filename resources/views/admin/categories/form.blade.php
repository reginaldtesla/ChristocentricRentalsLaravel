@extends('layouts.admin')

@section('title', $category->exists ? 'Edit category' : 'Add category')

@section('content')
    <form action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}" method="POST" class="max-w-xl space-y-4 rounded-xl border border-gray-200 bg-white p-6">
        @csrf
        @if ($category->exists) @method('PUT') @endif

        <div>
            <label class="mb-1 block text-sm font-medium">Name</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium">Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $category->slug) }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium">Sort order</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}" min="0" class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">
        </div>

        <button type="submit" class="btn-solid">Save category</button>
    </form>
@endsection
