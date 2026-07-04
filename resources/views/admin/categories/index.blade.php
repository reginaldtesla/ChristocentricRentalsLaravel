@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
    <div class="flex justify-end">
        <a href="{{ route('admin.categories.create') }}" class="btn-solid">Add category</a>
    </div>

    <div class="mt-6 overflow-hidden rounded-xl border border-gray-200 bg-white">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-500">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Slug</th>
                    <th class="px-4 py-3">Products</th>
                    <th class="px-4 py-3">Sort</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr class="border-t border-gray-100">
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $category->name }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $category->slug }}</td>
                        <td class="px-4 py-3">{{ $category->products_count }}</td>
                        <td class="px-4 py-3">{{ $category->sort_order }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="text-primary hover:underline">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $categories->links() }}</div>
@endsection
