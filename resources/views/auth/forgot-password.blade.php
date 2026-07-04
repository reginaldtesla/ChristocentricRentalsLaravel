@extends('layouts.app')

@section('title', 'Forgot Password — ' . config('app.name'))

@section('content')
    <div class="container-site py-16">
        <div class="mx-auto max-w-md rounded-2xl border border-gray-200 bg-white p-8 shadow-sm">
            <h1 class="text-2xl font-bold text-gray-900">Forgot password</h1>
            <p class="mt-2 text-sm text-gray-600">Enter your email and we will send you a reset link.</p>

            @if (session('status'))
                <div class="mt-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('status') }}</div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label for="email" class="mb-1 block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm">
                    @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="btn-solid w-full py-3">Send reset link</button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-600">
                <a href="{{ route('login') }}" class="font-semibold text-primary hover:underline">Back to sign in</a>
            </p>
        </div>
    </div>
@endsection
