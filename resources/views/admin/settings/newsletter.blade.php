@extends('layouts.admin')

@section('title', 'Newsletter section')

@section('content')
    <p class="text-sm text-gray-600">Copy for the newsletter band above the footer. Email issues are managed under Newsletters.</p>

    <form action="{{ route('admin.settings.newsletter.update') }}" method="POST" enctype="multipart/form-data" class="mt-6 max-w-3xl space-y-4 rounded-xl border border-gray-200 bg-white p-6">
        @csrf
        @method('PUT')

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-1 block text-sm font-medium">Eyebrow</label>
                <input type="text" name="eyebrow" value="{{ old('eyebrow', $newsletter['eyebrow']) }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium">Button label</label>
                <input type="text" name="button" value="{{ old('button', $newsletter['button']) }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">
            </div>
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium">Heading</label>
            <input type="text" name="heading" value="{{ old('heading', $newsletter['heading']) }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium">Subtext</label>
            <textarea name="subtext" rows="3" required class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">{{ old('subtext', $newsletter['subtext']) }}</textarea>
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium">Privacy note</label>
            <input type="text" name="privacy_note" value="{{ old('privacy_note', $newsletter['privacy_note']) }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">
        </div>
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-1 block text-sm font-medium">Signature name</label>
                <input type="text" name="founder_name" value="{{ old('founder_name', $newsletter['founder_name']) }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium">Signature role</label>
                <input type="text" name="founder_role" value="{{ old('founder_role', $newsletter['founder_role']) }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">
            </div>
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium">Quote</label>
            <textarea name="founder_quote" rows="5" required class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">{{ old('founder_quote', $newsletter['founder_quote']) }}</textarea>
        </div>
        <x-admin-image-upload
            name="founder_avatar"
            :value="old('founder_avatar', $newsletter['founder_avatar'])"
            label="Signature avatar"
        />

        <button type="submit" class="btn-solid">Save newsletter section</button>
    </form>
@endsection
