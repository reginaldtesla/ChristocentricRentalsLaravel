@extends('layouts.app')

@section('title', 'FAQ — ' . config('app.name'))

@section('content')
    @php($page = \App\Support\PageContent::get('faq'))

    <x-pages.hero :title="$page['hero_title']" :subtitle="$page['hero_subtitle']" />

    <div class="container-site faq-page">
        <div class="faq-list">
            @foreach ($page['items'] ?? [] as $item)
                <details class="faq-item">
                    <summary>
                        {{ $item['q'] }}
                        <span class="faq-toggle" aria-hidden="true">+</span>
                    </summary>
                    <p>{{ $item['a'] }}</p>
                </details>
            @endforeach
        </div>
        <p class="doc-footer-note">{{ $page['footer_note'] ?? '' }}</p>
    </div>
@endsection
