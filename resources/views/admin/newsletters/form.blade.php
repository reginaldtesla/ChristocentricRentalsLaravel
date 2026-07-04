@extends('layouts.admin')

@section('title', $newsletter->exists ? 'Edit Newsletter' : 'Compose Newsletter')

@section('content')
    <div class="flex flex-wrap items-center justify-end gap-4">
        <a href="{{ route('admin.newsletters.index') }}" class="text-sm text-primary hover:underline">Back to list</a>
    </div>

    @if ($newsletter->isSent())
        <div class="mt-6 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
            This newsletter was sent on {{ $newsletter->sent_at?->format('M j, Y g:i A') }} to {{ $newsletter->recipient_count }} subscriber(s).
        </div>
    @endif

    <form
        action="{{ $newsletter->exists ? route('admin.newsletters.update', $newsletter) : route('admin.newsletters.store') }}"
        method="POST"
        class="mt-6 max-w-3xl space-y-4 rounded-xl border border-gray-200 bg-white p-6"
    >
        @csrf
        @if ($newsletter->exists) @method('PUT') @endif

        <div>
            <label class="mb-1 block text-sm font-medium">Subject</label>
            <input
                type="text"
                name="subject"
                value="{{ old('subject', $newsletter->subject) }}"
                required
                @disabled($newsletter->isSent())
                class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm disabled:bg-gray-50"
            >
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium">Message</label>
            <textarea
                name="body"
                rows="14"
                required
                @disabled($newsletter->isSent())
                class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm leading-relaxed disabled:bg-gray-50"
                placeholder="Write your update here. New gear, rental tips, pickup reminders..."
            >{{ old('body', $newsletter->body) }}</textarea>
            <p class="mt-2 text-xs text-gray-500">Plain text is fine. Line breaks are preserved in the email.</p>
        </div>

        @unless ($newsletter->isSent())
            <div class="flex flex-wrap gap-3 pt-2">
                <button type="submit" class="btn-solid">Save draft</button>
            </div>
        @endunless
    </form>

    @if ($newsletter->exists && $newsletter->isDraft())
        <form
            action="{{ route('admin.newsletters.send', $newsletter) }}"
            method="POST"
            class="mt-4 max-w-3xl rounded-xl border border-primary/20 bg-primary-light p-6"
            onsubmit="return confirm('Send this newsletter to all active subscribers now?');"
        >
            @csrf
            <h2 class="text-lg font-semibold text-gray-900">Ready to send?</h2>
            <p class="mt-2 text-sm text-gray-600">
                This will email every active subscriber immediately. You cannot edit or resend this issue afterward.
            </p>
            <button type="submit" class="btn-solid mt-4">Send to all subscribers</button>
        </form>

        <form action="{{ route('admin.newsletters.destroy', $newsletter) }}" method="POST" class="mt-4" onsubmit="return confirm('Delete this draft?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-sm text-red-600 hover:underline">Delete draft</button>
        </form>
    @endif
@endsection
