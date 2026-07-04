@extends('layouts.admin')

@section('title', 'Site pages')

@section('content')
    <p class="text-sm text-gray-600">Edit About, FAQ, Help, Terms, and Privacy content shown on the public site.</p>

    <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($pages as $slug => $label)
            <a href="{{ route('admin.settings.pages.edit', $slug) }}" class="rounded-xl border border-gray-200 bg-white p-5 transition hover:border-primary hover:shadow-sm">
                <h2 class="font-semibold text-gray-900">{{ $label }}</h2>
                <p class="mt-1 text-sm text-primary">Edit page →</p>
            </a>
        @endforeach
    </div>
@endsection
