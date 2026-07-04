@extends('layouts.admin')

@section('title', 'Newsletters')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4">
        <p class="text-sm text-gray-600">{{ $subscriberCount }} active subscriber{{ $subscriberCount === 1 ? '' : 's' }}</p>
        <a href="{{ route('admin.newsletters.create') }}" class="btn-solid">Compose newsletter</a>
    </div>

    <div class="mt-6 overflow-hidden rounded-xl border border-gray-200 bg-white">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-500">
                <tr>
                    <th class="px-4 py-3">Subject</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Recipients</th>
                    <th class="px-4 py-3">Sent</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($newsletters as $newsletter)
                    <tr class="border-t border-gray-100">
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $newsletter->subject }}</td>
                        <td class="px-4 py-3 capitalize">{{ $newsletter->status }}</td>
                        <td class="px-4 py-3">{{ $newsletter->isSent() ? $newsletter->recipient_count : '—' }}</td>
                        <td class="px-4 py-3">{{ $newsletter->sent_at?->format('M j, Y g:i A') ?? '—' }}</td>
                        <td class="px-4 py-3 text-right">
                            @if ($newsletter->isDraft())
                                <a href="{{ route('admin.newsletters.edit', $newsletter) }}" class="text-primary hover:underline">Edit</a>
                            @else
                                <span class="text-gray-400">Sent</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">No newsletters yet. Compose your first issue.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $newsletters->links() }}</div>
@endsection
