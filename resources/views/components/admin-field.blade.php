@props([
    'label',
    'hint' => null,
    'for' => null,
])

<div {{ $attributes->merge(['class' => 'admin-field']) }}>
    <label @if($for) for="{{ $for }}" @endif class="admin-field-label">{{ $label }}</label>
    @if ($hint)
        <p class="admin-field-hint">{{ $hint }}</p>
    @endif
    <div class="admin-field-control">
        {{ $slot }}
    </div>
</div>
