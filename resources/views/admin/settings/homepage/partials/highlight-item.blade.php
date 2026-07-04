@props([
    'index',
    'item',
    'label' => 'Highlight',
    'open' => false,
])

@php
    $isTemplate = $index === '__INDEX__';
    $value = fn (string $key, mixed $default = '') => $isTemplate ? $default : old("deals_slides.$index.$key", $item[$key] ?? $default);
@endphp

<details class="admin-editor-item" @if($open) open @endif data-editor-item>
    <summary class="admin-editor-item-summary">
        @if(filled($item['image'] ?? null))
            <img src="{{ asset('images/'.$item['image']) }}" alt="" class="admin-editor-item-thumb" data-item-thumb>
        @else
            <span class="admin-editor-item-thumb admin-editor-item-thumb--empty" data-item-thumb-placeholder></span>
        @endif
        <span class="min-w-0 flex-1">
            <strong data-item-title-label>{{ $label }} {{ $isTemplate ? '' : ($index + 1) }}</strong>
            <span class="admin-editor-item-meta" data-item-title-preview>{{ $item['title'] ?? 'New item' }}</span>
        </span>
        <button type="button" class="admin-editor-remove-btn" data-editor-remove>Remove</button>
    </summary>
    <div class="admin-editor-item-body">
        <div class="admin-editor-item-media">
            <x-admin-image-upload name="deals_slides[{{ $index }}][image]" :value="$item['image'] ?? ''" label="Photo" />
        </div>
        <div class="admin-editor-item-fields">
            <div class="grid gap-4 sm:grid-cols-2">
                <x-admin-field label="Badge" hint="Small tag above the title, e.g. Just in">
                    <input type="text" name="deals_slides[{{ $index }}][badge]" value="{{ $value('badge', 'New') }}" required class="admin-input">
                </x-admin-field>
                <x-admin-field label="Title">
                    <input type="text" name="deals_slides[{{ $index }}][title]" value="{{ $value('title', 'New highlight') }}" required class="admin-input" data-item-title-source>
                </x-admin-field>
            </div>
            <x-admin-field label="Description">
                <textarea name="deals_slides[{{ $index }}][before]" rows="2" class="admin-input">{{ $value('before') }}</textarea>
            </x-admin-field>
            <x-admin-url-input name="deals_slides[{{ $index }}][url]" :value="$value('url', '/shop')" label="Link when clicked" :required="true" />
        </div>
    </div>
</details>
