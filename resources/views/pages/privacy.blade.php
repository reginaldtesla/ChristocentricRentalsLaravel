@extends('layouts.app')

@section('title', 'Privacy Policy — ' . config('app.name'))

@section('content')
    @php($page = \App\Support\PageContent::get('privacy'))

    <x-pages.hero :title="$page['hero_title']" :subtitle="$page['hero_subtitle']" />

    <x-pages.document :toc="\App\Support\PageContent::documentToc('privacy')">
        @if (filled($page['effective_date'] ?? null) && ! str_contains(\App\Support\PageContent::documentBodyHtml('privacy'), 'doc-date'))
            <p class="doc-date">Effective date: {{ $page['effective_date'] }}</p>
        @endif
        {!! \App\Support\PageContent::documentBodyHtml('privacy') !!}
    </x-pages.document>
@endsection
