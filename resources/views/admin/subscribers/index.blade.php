@extends('layouts.admin')

@section('title', 'Subscribers')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4">
        <p class="text-sm text-gray-600">{{ $activeCount }} active subscriber{{ $activeCount === 1 ? '' : 's' }}</p>
        <a href="{{ route('admin.subscribers.export') }}" class="btn-solid">Export CSV</a>
    </div>

    <div class="mt-6 overflow-hidden rounded-xl border border-gray-200 bg-white">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-500">
                <tr>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Subscribed</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($subscribers as $subscriber)
                    <tr class="border-t border-gray-100">
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $subscriber->email }}</td>
                        <td class="px-4 py-3">
                            @if ($subscriber->isActive())
                                <span class="rounded bg-green-50 px-2 py-0.5 text-xs font-medium text-green-700">Active</span>
                            @else
                                <span class="rounded bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-600">Unsubscribed</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $subscriber->subscribed_at?->format('M j, Y') }}</td>
                        <td class="px-4 py-3 text-right">
                            @if ($subscriber->isActive())
                                <form action="{{ route('admin.subscribers.destroy', $subscriber) }}" method="POST" class="inline" onsubmit="return confirm('Remove this subscriber?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Remove</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-4 py-8 text-center text-gray-500">No subscribers yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $subscribers->links() }}</div>
@endsection
