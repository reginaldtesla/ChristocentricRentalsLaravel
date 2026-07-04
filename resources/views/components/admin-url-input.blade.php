@props([
    'name',
    'value' => '',
    'label' => 'Link',
    'hint' => 'Where visitors go when they click.',
    'required' => false,
])

<div {{ $attributes->merge(['class' => 'admin-url-field']) }} data-url-field>
    <x-admin-field :label="$label" :hint="$hint">
        <input
            type="text"
            name="{{ $name }}"
            value="{{ $value }}"
            @if($required) required @endif
            placeholder="/shop"
            class="admin-input"
        >
        <div class="admin-url-suggestions">
            <span class="admin-url-suggestions-label">Quick links:</span>
            <button type="button" class="admin-url-chip" data-url-fill="/shop">Shop</button>
            <button type="button" class="admin-url-chip" data-url-fill="/shop?category=cameras">Cameras</button>
            <button type="button" class="admin-url-chip" data-url-fill="/shop?category=continuous-light">Lighting</button>
            <button type="button" class="admin-url-chip" data-url-fill="/contact">Contact</button>
        </div>
    </x-admin-field>
</div>
