@extends('layouts.app')

@section('title', 'About Us — ' . config('app.name'))

@section('content')
    @php($page = \App\Support\PageContent::get('about'))

    <x-pages.hero :title="$page['hero_title']" :subtitle="$page['hero_subtitle']" />

    <div class="container-site max-w-3xl py-12 prose prose-gray">
        <p class="text-lg text-gray-600 leading-relaxed">{{ $page['intro'] }}</p>

        @foreach ($page['sections'] ?? [] as $section)
            <h2 class="mt-10 text-xl font-semibold text-gray-900">{{ $section['heading'] }}</h2>
            <p class="text-gray-600 leading-relaxed">{{ $section['body'] }}</p>
        @endforeach

        @if (! empty($page['bullets']))
            <h2 class="mt-10 text-xl font-semibold text-gray-900">{{ $page['bullets_heading'] ?? 'Why Rent With Us' }}</h2>
            <ul class="mt-4 space-y-3 text-gray-600">
                @foreach ($page['bullets'] as $bullet)
                    <li>{{ $bullet }}</li>
                @endforeach
            </ul>
        @endif

        <div class="mt-10">
            <a href="{{ route('shop') }}" class="btn-solid">{{ $page['cta_text'] ?? 'Browse Our Gear' }}</a>
        </div>
    </div>
@endsection
