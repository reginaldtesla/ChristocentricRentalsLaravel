<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Admin') — {{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-shell">
    <x-admin-sidebar />

    <div class="admin-main">
        <header class="admin-topbar">
            <div>
                <h1 class="text-lg font-semibold text-gray-900">@yield('title', 'Admin')</h1>
                <p class="text-xs text-gray-500">Changes here update what customers see on the public site</p>
            </div>
            <a href="{{ route('home') }}" target="_blank" rel="noopener" class="admin-topbar-link">Preview site ↗</a>
        </header>

        <main class="admin-content">
            <x-flash-messages />
            @yield('content')
        </main>
    </div>
</body>
</html>
