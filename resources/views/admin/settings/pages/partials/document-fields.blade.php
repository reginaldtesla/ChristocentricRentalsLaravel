<div class="rounded-xl border border-gray-200 bg-white p-6 space-y-4">
    <h2 class="text-lg font-semibold text-gray-900">Page body</h2>

    @if ($showEffectiveDate ?? false)
        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">Effective date</label>
            <input type="text" name="effective_date" value="{{ old('effective_date', $content['effective_date'] ?? '') }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">
        </div>
    @endif

    <div>
        <label class="mb-1 block text-sm font-medium text-gray-700">HTML content</label>
        <p class="mb-2 text-xs text-gray-500">Leave blank to use the default page content. You can use basic HTML: headings, paragraphs, lists, links.</p>
        <textarea name="body_html" rows="24" class="w-full rounded-lg border border-gray-300 px-4 py-2 font-mono text-xs">{{ old('body_html', $content['body_html'] ?? '') }}</textarea>
    </div>

    @if ($defaultBody)
        <details class="text-sm text-gray-600">
            <summary class="cursor-pointer font-medium text-gray-800">View default content reference</summary>
            <pre class="mt-3 max-h-64 overflow-auto rounded bg-gray-50 p-3 text-xs">{{ $defaultBody }}</pre>
        </details>
    @endif
</div>
