<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('meta_description', 'Premium camera, lens, lighting and filmmaking gear rentals in Ghana.')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png" sizes="32x32">
    <link rel="icon" href="{{ asset('images/brand/icon.png') }}" type="image/png" sizes="512x512">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    <title>@yield('title', config('app.name'))</title>

    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col bg-white pb-16 md:pb-0">
    @include('components.header')

    <main class="flex-1">
@if (session('success') || session('error') || ($errors ?? null)?->any())
    <div class="container-site pt-4">
        <x-flash-messages />
    </div>
@endif
        @yield('content')
    </main>

    @include('components.footer')
    @include('components.mobile-nav')
</body>
</html>
