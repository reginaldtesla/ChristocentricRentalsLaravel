<div class="rounded-xl border border-gray-200 bg-white p-6 space-y-4">
    <h2 class="text-lg font-semibold text-gray-900">Questions & answers</h2>

    @php($items = old('items', $content['items'] ?? []))
    @foreach ($items as $index => $item)
        <div class="rounded-lg border border-gray-100 bg-gray-50 p-4 space-y-3">
            <p class="text-sm font-medium text-gray-700">Item {{ $index + 1 }}</p>
            <input type="text" name="items[{{ $index }}][q]" value="{{ $item['q'] ?? '' }}" required placeholder="Question" class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">
            <textarea name="items[{{ $index }}][a]" rows="3" required placeholder="Answer" class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">{{ $item['a'] ?? '' }}</textarea>
        </div>
    @endforeach

    <div>
        <label class="mb-1 block text-sm font-medium text-gray-700">Footer note</label>
        <input type="text" name="footer_note" value="{{ old('footer_note', $content['footer_note'] ?? '') }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">
    </div>
</div>
