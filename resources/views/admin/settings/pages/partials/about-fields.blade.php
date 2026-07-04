<div class="rounded-xl border border-gray-200 bg-white p-6 space-y-4">
    <h2 class="text-lg font-semibold text-gray-900">About content</h2>
    <div>
        <label class="mb-1 block text-sm font-medium text-gray-700">Introduction</label>
        <textarea name="intro" rows="4" required class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">{{ old('intro', $content['intro'] ?? '') }}</textarea>
    </div>

    @php($sections = old('sections', $content['sections'] ?? []))
    @foreach ($sections as $index => $section)
        <div class="rounded-lg border border-gray-100 bg-gray-50 p-4 space-y-3">
            <p class="text-sm font-medium text-gray-700">Section {{ $index + 1 }}</p>
            <input type="text" name="sections[{{ $index }}][heading]" value="{{ $section['heading'] ?? '' }}" required placeholder="Heading" class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">
            <textarea name="sections[{{ $index }}][body]" rows="3" required placeholder="Body text" class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">{{ $section['body'] ?? '' }}</textarea>
        </div>
    @endforeach

    <div>
        <label class="mb-1 block text-sm font-medium text-gray-700">Bullet list heading</label>
        <input type="text" name="bullets_heading" value="{{ old('bullets_heading', $content['bullets_heading'] ?? 'Why Rent With Us') }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">
    </div>

    @php($bullets = old('bullets', $content['bullets'] ?? []))
    @foreach ($bullets as $index => $bullet)
        <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">Bullet {{ $index + 1 }}</label>
            <input type="text" name="bullets[{{ $index }}]" value="{{ $bullet }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">
        </div>
    @endforeach

    <div>
        <label class="mb-1 block text-sm font-medium text-gray-700">Button text</label>
        <input type="text" name="cta_text" value="{{ old('cta_text', $content['cta_text'] ?? 'Browse Our Gear') }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">
    </div>
</div>
