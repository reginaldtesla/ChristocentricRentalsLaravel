@extends('layouts.admin')

@section('title', 'Footer & trust bar')

@section('content')
    <form action="{{ route('admin.settings.footer.update') }}" method="POST" class="max-w-3xl space-y-8">
        @csrf
        @method('PUT')

        <section class="rounded-xl border border-gray-200 bg-white p-6">
            <h2 class="text-base font-semibold text-gray-900">Trust bar (below hero)</h2>
            <div class="mt-4 space-y-4">
                @foreach ($trustFeatures as $index => $feature)
                    <div class="grid gap-3 rounded-lg border border-gray-100 bg-gray-50 p-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-xs font-medium uppercase text-gray-500">Title {{ $index + 1 }}</label>
                            <input type="text" name="trust_features[{{ $index }}][title]" value="{{ old("trust_features.$index.title", $feature['title']) }}" required class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium uppercase text-gray-500">Subtitle</label>
                            <input type="text" name="trust_features[{{ $index }}][subtitle]" value="{{ old("trust_features.$index.subtitle", $feature['subtitle']) }}" required class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="rounded-xl border border-gray-200 bg-white p-6">
            <h2 class="text-base font-semibold text-gray-900">Footer feature row</h2>
            <div class="mt-4 space-y-4">
                @foreach ($footerFeatures as $index => $feature)
                    <div class="grid gap-3 rounded-lg border border-gray-100 bg-gray-50 p-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-xs font-medium uppercase text-gray-500">Title {{ $index + 1 }}</label>
                            <input type="text" name="footer_features[{{ $index }}][title]" value="{{ old("footer_features.$index.title", $feature['title']) }}" required class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                        </div>
                        <div>
                            <label class="mb-1 block text-xs font-medium uppercase text-gray-500">Subtitle</label>
                            <input type="text" name="footer_features[{{ $index }}][subtitle]" value="{{ old("footer_features.$index.subtitle", $feature['subtitle']) }}" required class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="rounded-xl border border-gray-200 bg-white p-6">
            <h2 class="text-base font-semibold text-gray-900">Brand strip</h2>
            <label class="mb-1 mt-4 block text-sm font-medium">Brand names (comma-separated)</label>
            <textarea name="brands" rows="3" required class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">{{ old('brands', $brands) }}</textarea>
        </section>

        <button type="submit" class="btn-solid">Save footer content</button>
    </form>
@endsection
