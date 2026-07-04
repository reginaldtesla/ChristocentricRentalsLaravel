@props([
    'index',
    'item',
    'label' => 'Item',
    'open' => false,
])

@php
    $isTemplate = $index === '__INDEX__';
    $value = fn (string $key, mixed $default = '') => $isTemplate ? $default : old("featured_lighting.$index.$key", $item[$key] ?? $default);
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
            <x-admin-image-upload name="featured_lighting[{{ $index }}][image]" :value="$item['image'] ?? ''" label="Photo" />
        </div>
        <div class="admin-editor-item-fields">
            <x-admin-field label="Title">
                <input type="text" name="featured_lighting[{{ $index }}][title]" value="{{ $value('title', 'New item') }}" required class="admin-input" data-item-title-source>
            </x-admin-field>
            <x-admin-field label="Description">
                <input type="text" name="featured_lighting[{{ $index }}][description]" value="{{ $value('description') }}" required class="admin-input">
            </x-admin-field>
        </div>
    </div>
</details>
