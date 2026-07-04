@extends('layouts.app')

@section('title', 'Register — ' . config('app.name'))

@section('content')
    <div class="container-site py-16">
        <div class="mx-auto max-w-md rounded-2xl border border-gray-200 bg-white p-8 shadow-sm">
            <h1 class="text-2xl font-bold text-gray-900">Create Account</h1>
            <p class="mt-2 text-sm text-gray-600">Register to browse availability, add items to cart, and complete rentals.</p>
            <form action="{{ route('register') }}" method="POST" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label for="name" class="mb-1 block text-sm font-medium text-gray-700">Full name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm">
                </div>
                <div>
                    <label for="email" class="mb-1 block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm">
                </div>
                <div>
                    <label for="phone" class="mb-1 block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm">
                </div>
                <div>
                    <label for="password" class="mb-1 block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" required class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm">
                </div>
                <div>
                    <label for="password_confirmation" class="mb-1 block text-sm font-medium text-gray-700">Confirm password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm">
                </div>
                <button type="submit" class="btn-solid w-full py-3">Register</button>
            </form>
            <p class="mt-6 text-center text-sm text-gray-600">
                Already have an account? <a href="{{ route('login') }}" class="font-semibold text-primary hover:underline">Login</a>
            </p>
        </div>
    </div>
@endsection
