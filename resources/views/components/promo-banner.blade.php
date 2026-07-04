@props([
    'title',
    'description' => '',
    'image',
    'bg' => '#f3f4f6',
    'url' => '#',
    'size' => 'md',
    'dark' => false,
])

@php
    $height = match ($size) {
        'sm' => 'min-h-[220px]',
        'lg' => 'min-h-[320px]',
        default => 'min-h-[260px]',
    };
@endphp

<a
    href="{{ $url }}"
    class="promo-banner group relative flex {{ $height }} flex-col justify-end overflow-hidden rounded-2xl p-5 transition hover:shadow-lg md:p-6 {{ $dark ? 'promo-banner-dark' : 'promo-banner-pastel' }}"
    style="{{ $dark ? '' : 'background-color: ' . $bg }}"
>
    @if ($dark)
        <div
            class="pointer-events-none absolute inset-0 bg-cover bg-center opacity-60"
            style="background-image: url('{{ asset('images/' . $image) }}')"
        ></div>
        <div class="pointer-events-none absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>
    @else
        <div class="pointer-events-none absolute inset-0 flex items-end justify-center pb-2">
            <img
                src="{{ asset('images/' . $image) }}"
                alt=""
                class="max-h-[55%] max-w-[75%] object-contain transition duration-500 group-hover:scale-105"
                loading="lazy"
            >
        </div>
    @endif
    <div class="relative z-10 {{ $dark ? 'max-w-md text-white' : '' }}">
        <h3 class="text-lg font-bold leading-tight md:text-xl">{!! nl2br(e($title)) !!}</h3>
        @if ($description)
            <p class="mt-2 text-sm leading-relaxed {{ $dark ? 'text-white/85' : 'text-gray-600' }}">{{ $description }}</p>
        @endif
        <span class="mt-4 inline-flex rounded-full {{ $dark ? 'bg-white px-5 py-2 text-sm font-semibold text-gray-900' : 'bg-gray-900 px-4 py-2 text-xs font-semibold text-white md:text-sm' }} transition group-hover:bg-primary">
            Rent Now
        </span>
    </div>
</a>
