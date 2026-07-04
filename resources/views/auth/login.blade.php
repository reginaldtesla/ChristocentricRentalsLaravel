@extends('layouts.app')

@section('title', 'Login — ' . config('app.name'))

@section('content')
    <div class="container-site py-16">
        <div class="mx-auto max-w-md rounded-2xl border border-gray-200 bg-white p-8 shadow-sm">
            <h1 class="text-2xl font-bold text-gray-900">Customer sign in</h1>
            <p class="mt-2 text-sm text-gray-600">Sign in to rent gear, checkout, and view your orders.</p>
            @if (session('status'))
                <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('status') }}</div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label for="email" class="mb-1 block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm">
                </div>
                <div>
                    <label for="password" class="mb-1 block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" required class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm">
                    <p class="mt-2 text-right text-sm">
                        <a href="{{ route('password.request') }}" class="text-primary hover:underline">Forgot password?</a>
                    </p>
                </div>
                <label class="flex items-center gap-2 text-sm text-gray-600">
                    <input type="checkbox" name="remember" class="rounded border-gray-300">
                    Remember me
                </label>
                <button type="submit" class="btn-solid w-full py-3">Log in</button>
            </form>
            <p class="mt-6 text-center text-sm text-gray-600">
                No account? <a href="{{ route('register') }}" class="font-semibold text-primary hover:underline">Register</a>
            </p>
        </div>
    </div>
@endsection
