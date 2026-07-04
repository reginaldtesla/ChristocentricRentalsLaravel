@extends('layouts.admin-auth')

@section('content')
    <div class="admin-auth-card">
        <div class="admin-auth-brand">
            <img src="{{ asset('images/brand/icon.png') }}" alt="" class="admin-auth-logo">
            <h1 class="text-xl font-bold text-white">{{ config('app.name') }}</h1>
            <p class="mt-1 text-sm text-blue-200">Site manager — not the customer storefront</p>
        </div>

        <div class="admin-auth-body">
            <h2 class="text-lg font-semibold text-gray-900">Admin sign in</h2>
            <p class="mt-1 text-sm text-gray-600">Manage products, orders, homepage content, and everything visitors see on the site.</p>

            @if ($errors->any())
                <div class="mt-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('admin.login') }}" method="POST" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label for="email" class="mb-1 block text-sm font-medium text-gray-700">Admin email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm">
                </div>
                <div>
                    <label for="password" class="mb-1 block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" required class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm">
                </div>
                <label class="flex items-center gap-2 text-sm text-gray-600">
                    <input type="checkbox" name="remember" class="rounded border-gray-300">
                    Remember me on this device
                </label>
                <button type="submit" class="btn-solid w-full py-3">Enter site manager</button>
            </form>

            <p class="mt-6 text-center text-xs text-gray-500">
                Looking to rent gear?
                <a href="{{ route('home') }}" class="font-medium text-primary hover:underline">Go to the public site</a>
            </p>
        </div>
    </div>
@endsection
