@extends('layouts.admin')

@section('title', 'Edit '.$pageTitle)

@section('content')
    <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
        <a href="{{ route('admin.settings.pages') }}" class="text-sm text-primary hover:underline">← All site pages</a>
        <a href="{{ match($page) {
            'about' => route('about'),
            'faq' => route('faq'),
            'help' => route('help'),
            'terms' => route('terms'),
            'privacy' => route('privacy'),
            default => route('home'),
        } }}" target="_blank" rel="noopener" class="text-sm text-gray-600 hover:text-primary">Preview page ↗</a>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.settings.pages.update', $page) }}" method="POST" class="max-w-4xl space-y-6">
        @csrf
        @method('PUT')

        <div class="rounded-xl border border-gray-200 bg-white p-6 space-y-4">
            <h2 class="text-lg font-semibold text-gray-900">Page header</h2>
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="hero_title" value="{{ old('hero_title', $content['hero_title'] ?? '') }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Subtitle</label>
                <input type="text" name="hero_subtitle" value="{{ old('hero_subtitle', $content['hero_subtitle'] ?? '') }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">
            </div>
        </div>

        @if ($page === 'about')
            @include('admin.settings.pages.partials.about-fields', ['content' => $content])
        @elseif ($page === 'faq')
            @include('admin.settings.pages.partials.faq-fields', ['content' => $content])
        @else
            @include('admin.settings.pages.partials.document-fields', [
                'content' => $content,
                'defaultBody' => $defaultBody,
                'showEffectiveDate' => in_array($page, ['terms', 'privacy'], true),
            ])
        @endif

        <button type="submit" class="btn-solid">Save page</button>
    </form>
@endsection
