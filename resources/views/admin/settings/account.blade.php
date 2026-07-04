@extends('layouts.admin')

@section('title', 'Admin login')

@section('content')
    <p class="text-sm text-gray-600">Change the admin email and password used to sign in at <code class="rounded bg-gray-100 px-1">/login</code>. Credentials are saved to <code class="rounded bg-gray-100 px-1">.env</code>.</p>

    <form action="{{ route('admin.settings.account.update') }}" method="POST" class="mt-6 max-w-xl space-y-4 rounded-xl border border-gray-200 bg-white p-6">
        @csrf
        @method('PUT')

        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">Display name</label>
            <input type="text" name="name" value="{{ old('name', $name) }}" required class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">Login email</label>
            <input type="email" name="email" value="{{ old('email', $email) }}" required class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">New password</label>
            <input type="password" name="password" autocomplete="new-password" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" placeholder="Leave blank to keep current password">
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">Confirm new password</label>
            <input type="password" name="password_confirmation" autocomplete="new-password" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
        </div>

        <button type="submit" class="btn-solid">Save admin login</button>
    </form>
@endsection
