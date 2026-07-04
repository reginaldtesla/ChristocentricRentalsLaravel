@extends('layouts.app')

@section('title', 'My Profile — ' . config('app.name'))

@section('content')
    <x-pages.hero title="My Profile" subtitle="Update your account details." />

    <div class="container-site max-w-2xl py-10">
        @include('account._nav')

        @if (session('success'))
            <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
        @endif

        <form action="{{ route('account.profile.update') }}" method="POST" class="space-y-4 rounded-2xl border border-gray-200 bg-white p-6">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="mb-1 block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm">
                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="email" class="mb-1 block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm">
                @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="phone" class="mb-1 block text-sm font-medium text-gray-700">Phone</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm">
                @error('phone')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="btn-solid">Save profile</button>
        </form>

        <form action="{{ route('account.profile.password') }}" method="POST" class="mt-8 space-y-4 rounded-2xl border border-gray-200 bg-white p-6">
            @csrf
            @method('PUT')

            <h2 class="text-lg font-semibold text-gray-900">Change password</h2>

            <div>
                <label for="current_password" class="mb-1 block text-sm font-medium text-gray-700">Current password</label>
                <input type="password" id="current_password" name="current_password" required class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm">
                @error('current_password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="password" class="mb-1 block text-sm font-medium text-gray-700">New password</label>
                <input type="password" id="password" name="password" required class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm">
                @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="password_confirmation" class="mb-1 block text-sm font-medium text-gray-700">Confirm new password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm">
            </div>

            <button type="submit" class="btn-solid">Update password</button>
        </form>

        <form action="{{ route('logout') }}" method="POST" class="mt-8">
            @csrf
            <button type="submit" class="text-sm text-gray-500 hover:text-red-600">Log out</button>
        </form>
    </div>
@endsection
