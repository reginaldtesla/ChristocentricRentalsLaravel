@props([
    'name',
    'value' => '',
    'label' => 'Image',
    'hint' => 'Upload a photo — JPG, PNG, WebP, GIF or AVIF, max 5 MB.',
])

@php
    $storedValue = old(str_replace(['[', ']'], ['.', ''], $name), $value);
    $fileName = str_ends_with($name, '[image]')
        ? str_replace('[image]', '[image_file]', $name)
        : $name.'_file';
    $previewUrl = filled($storedValue) ? asset('images/'.$storedValue) : null;
    $inputId = 'upload-'.md5($name);
@endphp

<div {{ $attributes->merge(['class' => 'admin-image-upload']) }} data-admin-image-upload>
    <label for="{{ $inputId }}" class="admin-field-label">{{ $label }}</label>
    @if ($hint)
        <p class="admin-field-hint">{{ $hint }}</p>
    @endif

    <div class="admin-image-dropzone">
        <div class="admin-image-preview-wrap" data-admin-image-preview-wrap @if(! $previewUrl) hidden @endif>
            <img src="{{ $previewUrl }}" alt="" class="admin-image-preview-img" data-admin-image-preview>
        </div>
        <div class="admin-image-dropzone-inner">
            <p class="text-sm font-medium text-gray-700">Choose an image</p>
            <p class="mt-1 text-xs text-gray-500">Click to browse or replace the current photo</p>
            <input type="hidden" name="{{ $name }}" value="{{ $storedValue }}" data-admin-image-path>
            <input
                id="{{ $inputId }}"
                type="file"
                name="{{ $fileName }}"
                accept="image/jpeg,image/png,image/webp,image/gif,image/avif"
                class="admin-image-file-input"
                data-admin-image-input
            >
        </div>
    </div>
</div>
