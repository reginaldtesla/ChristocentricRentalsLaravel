@extends('layouts.app')

@section('title', 'Reset Password — ' . config('app.name'))

@section('content')
    <div class="container-site py-16">
        <div class="mx-auto max-w-md rounded-2xl border border-gray-200 bg-white p-8 shadow-sm">
            <h1 class="text-2xl font-bold text-gray-900">Reset password</h1>
            <p class="mt-2 text-sm text-gray-600">Choose a new password for your account.</p>

            <form action="{{ route('password.update') }}" method="POST" class="mt-6 space-y-4">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label for="email" class="mb-1 block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $email) }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm">
                    @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="password" class="mb-1 block text-sm font-medium text-gray-700">New password</label>
                    <input type="password" id="password" name="password" required class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm">
                    @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="password_confirmation" class="mb-1 block text-sm font-medium text-gray-700">Confirm password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm">
                </div>

                <button type="submit" class="btn-solid w-full py-3">Reset password</button>
            </form>
        </div>
     </div>
@endsection
