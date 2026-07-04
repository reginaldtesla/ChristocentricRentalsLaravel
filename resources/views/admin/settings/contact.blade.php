@extends('layouts.admin')

@section('title', 'Contact info')

@section('content')
    <p class="text-sm text-gray-600">Shown on the contact page, footer, and policy pages.</p>

    <form action="{{ route('admin.settings.contact.update') }}" method="POST" class="mt-6 max-w-2xl space-y-4 rounded-xl border border-gray-200 bg-white p-6">
        @csrf
        @method('PUT')

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-1 block text-sm font-medium">General email</label>
                <input type="email" name="email" value="{{ old('email', $contact['email']) }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium">Support email</label>
                <input type="email" name="support_email" value="{{ old('support_email', $contact['support_email']) }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium">Feedback email</label>
                <input type="email" name="feedback_email" value="{{ old('feedback_email', $contact['feedback_email']) }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium">Phone (tel link)</label>
                <input type="text" name="phone" value="{{ old('phone', $contact['phone']) }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium">Phone (display)</label>
                <input type="text" name="phone_display" value="{{ old('phone_display', $contact['phone_display']) }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">
            </div>
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium">Address</label>
            <input type="text" name="address" value="{{ old('address', $contact['address']) }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium">City</label>
            <input type="text" name="city" value="{{ old('city', $contact['city']) }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">
        </div>

        <button type="submit" class="btn-solid">Save contact info</button>
    </form>
@endsection
