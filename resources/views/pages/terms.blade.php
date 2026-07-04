@extends('layouts.app')

@section('title', 'Terms & Conditions — ' . config('app.name'))

@section('content')
    @php($page = \App\Support\PageContent::get('terms'))

    <x-pages.hero :title="$page['hero_title']" :subtitle="$page['hero_subtitle']" />

    <x-pages.document :toc="\App\Support\PageContent::documentToc('terms')">
        @if (filled($page['effective_date'] ?? null) && ! str_contains(\App\Support\PageContent::documentBodyHtml('terms'), 'doc-date'))
            <p class="doc-date">Effective date: {{ $page['effective_date'] }}</p>
        @endif
        {!! \App\Support\PageContent::documentBodyHtml('terms') !!}
    </x-pages.document>
@endsection
