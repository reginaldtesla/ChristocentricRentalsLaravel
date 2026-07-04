@props([
    'index',
    'item',
    'label' => 'Slide',
    'open' => false,
])

@php
    $isTemplate = $index === '__INDEX__';
    $oldPrefix = $isTemplate ? null : "hero_slides.$index";
    $value = fn (string $key, mixed $default = '') => $isTemplate ? $default : old("hero_slides.$index.$key", $item[$key] ?? $default);
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
            <x-admin-image-upload
                name="hero_slides[{{ $index }}][image]"
                :value="$item['image'] ?? ''"
                label="Photo"
                hint="Product or gear photo shown on the right side of the slide."
            />
        </div>
        <div class="admin-editor-item-fields">
            <x-admin-field label="Small label above headline" hint="Example: Cameras, Lighting, Aerial">
                <input type="text" name="hero_slides[{{ $index }}][subtitle]" value="{{ $value('subtitle') }}" required class="admin-input" placeholder="Cameras" data-item-title-source>
            </x-admin-field>
            <x-admin-field label="Headline" hint="Main big text visitors read first.">
                <input type="text" name="hero_slides[{{ $index }}][title]" value="{{ $value('title', 'New slide') }}" required class="admin-input" placeholder="Canon EOS R5" data-item-title-source>
            </x-admin-field>
            <x-admin-field label="Short description" hint="One or two sentences about the gear or offer.">
                <textarea name="hero_slides[{{ $index }}][description]" rows="3" required class="admin-input">{{ $value('description') }}</textarea>
            </x-admin-field>
            <div class="grid gap-4 sm:grid-cols-2">
                <x-admin-field label="Button text" hint="Example: Browse cameras">
                    <input type="text" name="hero_slides[{{ $index }}][cta_primary]" value="{{ $value('cta_primary', 'Browse gear') }}" required class="admin-input" placeholder="Browse gear">
                </x-admin-field>
                <x-admin-url-input
                    name="hero_slides[{{ $index }}][cta_url]"
                    :value="$value('cta_url', '/shop')"
                    label="Button link"
                    :required="true"
                />
            </div>
        </div>
    </div>
</details>
