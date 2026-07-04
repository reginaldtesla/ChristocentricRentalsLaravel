@extends('layouts.app')

@section('title', 'Help & Support — ' . config('app.name'))

@section('content')
    @php($page = \App\Support\PageContent::get('help'))

    <x-pages.hero :title="$page['hero_title']" :subtitle="$page['hero_subtitle']" />

    <x-pages.document :toc="\App\Support\PageContent::documentToc('help')">
        {!! \App\Support\PageContent::documentBodyHtml('help') !!}
    </x-pages.document>
@endsection
