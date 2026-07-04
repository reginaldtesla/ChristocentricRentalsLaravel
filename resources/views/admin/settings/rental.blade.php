@extends('layouts.admin')

@section('title', 'Rental & penalties')

@section('content')
    <p class="text-sm text-gray-600">Configure grace period and late-return penalties. Countdown timers on orders use each item’s return date and time.</p>

    <form action="{{ route('admin.settings.rental.update') }}" method="POST" class="mt-6 max-w-2xl space-y-4 rounded-xl border border-gray-200 bg-white p-6">
        @csrf
        @method('PUT')

        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">Grace period (minutes)</label>
            <p class="mb-2 text-xs text-gray-500">No penalty if gear is returned within this many minutes after the scheduled return time.</p>
            <input type="number" name="grace_minutes" min="0" max="1440" value="{{ old('grace_minutes', $penalties['grace_minutes'] ?? 30) }}" required class="w-32 rounded-lg border border-gray-300 px-4 py-2 text-sm">
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">Late penalty multiplier</label>
            <p class="mb-2 text-xs text-gray-500">Each late day is charged as this many times the item’s daily rental rate (× quantity). Example: 1 = one full day’s rent per late day.</p>
            <input type="number" name="daily_rate_multiplier" min="0" max="10" step="0.1" value="{{ old('daily_rate_multiplier', $penalties['daily_rate_multiplier'] ?? 1) }}" required class="w-32 rounded-lg border border-gray-300 px-4 py-2 text-sm">
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">“Due soon” warning (hours)</label>
            <p class="mb-2 text-xs text-gray-500">Show amber countdown warnings when return is within this many hours.</p>
            <input type="number" name="due_soon_hours" min="1" max="168" value="{{ old('due_soon_hours', $penalties['due_soon_hours'] ?? 24) }}" required class="w-32 rounded-lg border border-gray-300 px-4 py-2 text-sm">
        </div>

        <button type="submit" class="btn-solid">Save rules</button>
    </form>
@endsection
