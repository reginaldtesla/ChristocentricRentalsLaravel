@props([
    'index',
    'item',
    'label' => 'Card',
    'open' => false,
])

@php
    $isTemplate = $index === '__INDEX__';
    $value = fn (string $key, mixed $default = '') => $isTemplate ? $default : old("brand_banners.$index.$key", $item[$key] ?? $default);
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
            <x-admin-image-upload name="brand_banners[{{ $index }}][image]" :value="$item['image'] ?? ''" label="Card photo" />
        </div>
        <div class="admin-editor-item-fields">
            <x-admin-field label="Category name">
                <input type="text" name="brand_banners[{{ $index }}][title]" value="{{ $value('title', 'New category') }}" required class="admin-input" data-item-title-source>
            </x-admin-field>
            <x-admin-field label="Short line under the name">
                <input type="text" name="brand_banners[{{ $index }}][description]" value="{{ $value('description') }}" required class="admin-input">
            </x-admin-field>
            <x-admin-url-input name="brand_banners[{{ $index }}][url]" :value="$value('url', '/shop')" label="Link when card is clicked" :required="true" />
        </div>
    </div>
</details>
