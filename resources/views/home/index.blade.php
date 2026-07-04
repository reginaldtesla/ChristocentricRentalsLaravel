@extends('layouts.app')

@section('title', config('app.name') . ' — Camera & Filmmaking Gear Rentals')

@section('content')
    {{-- Hero --}}
    <section class="carousel-shell" data-hero-slider>
        <div class="relative min-h-[380px] md:min-h-[440px]">
            @foreach (config('site.hero_slides') as $index => $slide)
                <div
                    data-hero-slide
                    class="carousel-slide absolute inset-0 transition-opacity duration-500 {{ $index === 0 ? 'opacity-100' : 'pointer-events-none opacity-0' }}"
                >
                    <div class="container-site flex h-full min-h-[380px] flex-col md:min-h-[440px] md:flex-row md:items-center md:gap-12">
                        <div class="flex flex-1 flex-col justify-center py-10 md:py-12 md:pr-4">
                            <p class="text-sm text-gray-500">{{ $slide['subtitle'] }}</p>
                            <h1 class="mt-1 text-3xl font-semibold leading-tight text-gray-900 md:text-4xl lg:text-[2.75rem]">{{ $slide['title'] }}</h1>
                            <p class="mt-3 max-w-md text-base leading-relaxed text-gray-600">{{ $slide['description'] }}</p>
                            <a href="{{ url($slide['cta_url'] ?? '/shop') }}" class="btn-solid mt-7 w-fit">{{ $slide['cta_primary'] ?? 'Browse gear' }}</a>
                        </div>
                        <div class="carousel-product-stage flex-1 pb-8 md:pb-0">
                            <img src="{{ asset('images/' . $slide['image']) }}" alt="{{ $slide['title'] }}">
                        </div>
                    </div>
                </div>
            @endforeach
            <button type="button" data-hero-prev class="carousel-arrow carousel-arrow-prev" aria-label="Previous"><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></button>
            <button type="button" data-hero-next class="carousel-arrow carousel-arrow-next" aria-label="Next"><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></button>
        </div>
    </section>

    <x-trust-bar :features="config('site.trust_features')" />

    {{-- Popular picks --}}
    <section class="home-section container-site">
        <x-section-title title="Popular right now" :link="route('shop')" link-text="All products" />
        <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_280px]">
            <div class="min-w-0">
                <x-product-scroll :products="$popularProducts" />
            </div>
            <aside class="hidden lg:block">
                <div class="sidebar-note sticky top-24">
                    <p class="text-sm font-medium text-gray-900">Lighting kits</p>
                    <p class="mt-2 text-sm leading-relaxed text-gray-600">LED panels and modifiers for interviews, film sets and events.</p>
                    <div class="mt-5 flex justify-center rounded border border-gray-100 bg-gray-50 p-5">
                        <img src="{{ asset('images/storage/2024/10/den-led-tolifo-kw-200b-4-300x300.jpg') }}" alt="LED panel" class="max-h-36 object-contain">
                    </div>
                    <a href="{{ route('shop', ['category' => 'continuous-light']) }}" class="mt-5 block text-sm font-medium text-primary hover:underline">Browse lights</a>
                </div>
            </aside>
        </div>
    </section>

    {{-- Highlighted gear --}}
    <section class="home-section home-section-alt">
        <div class="container-site">
            <x-section-title title="Highlighted this week" :link="route('shop')" link-text="See catalog" size="large" />
            <div class="relative" data-deals-slider>
                <div class="deals-panel relative overflow-hidden rounded border border-gray-200 bg-white">
                    @foreach (config('site.deals_slides') as $index => $deal)
                        <div
                            data-deals-slide
                            class="transition-opacity duration-500 {{ $index === 0 ? 'opacity-100' : 'pointer-events-none absolute inset-0 opacity-0' }}"
                        >
                            <div class="grid items-center md:grid-cols-2">
                                <div class="p-8 md:p-10">
                                    <p class="text-sm text-gray-500">{{ $deal['badge'] }}</p>
                                    <h3 class="mt-1 text-2xl font-semibold text-gray-900 md:text-3xl">{{ $deal['title'] }}</h3>
                                    @if (!empty($deal['before']))
                                        <p class="mt-3 text-sm leading-relaxed text-gray-600">{{ $deal['before'] }}</p>
                                    @endif
                                    <a href="{{ url($deal['url'] ?? '/shop') }}" class="btn-solid mt-6">View in shop</a>
                                </div>
                                <div class="flex items-center justify-center bg-gray-50 p-8 md:p-10">
                                    <img src="{{ asset('images/' . $deal['image']) }}" alt="{{ $deal['title'] }}" class="max-h-52 object-contain md:max-h-64">
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <button type="button" data-deals-prev class="carousel-arrow carousel-arrow-prev" aria-label="Previous"><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></button>
                    <button type="button" data-deals-next class="carousel-arrow carousel-arrow-next" aria-label="Next"><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></button>
                </div>
            </div>
        </div>
    </section>

    {{-- Categories --}}
    <section class="home-section container-site">
        <x-section-title title="Browse by category" :link="route('shop')" link-text="Full catalog" />
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach (config('site.brand_banners') as $banner)
                <x-category-card
                    :title="$banner['title']"
                    :description="$banner['description']"
                    :image="$banner['image']"
                    :url="url($banner['url'])"
                />
            @endforeach
        </div>
    </section>

    {{-- Staff picks --}}
    <section class="home-section container-site">
        <x-section-title title="Staff picks" :link="route('shop')" link-text="More gear" size="large" />
        <div class="grid gap-4 md:grid-cols-3">
            @foreach (config('site.weekly_deals') as $deal)
                <a href="{{ url($deal['url']) }}" class="pick-card group block overflow-hidden rounded border border-gray-200 bg-white transition hover:border-gray-300">
                    <div class="aspect-[16/10] overflow-hidden bg-gray-100">
                        <img src="{{ asset('images/' . $deal['image']) }}" alt="" class="h-full w-full object-cover object-center transition duration-300 group-hover:scale-[1.02]">
                    </div>
                    <div class="p-5">
                        <h3 class="font-medium text-gray-900">{{ $deal['title'] }}</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ $deal['description'] }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Featured lighting --}}
    <section class="home-section home-section-alt">
        <div class="container-site">
            <x-section-title title="Lighting &amp; grip" :link="route('shop', ['category' => 'continuous-light'])" link-text="All lighting" />
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach (config('site.featured_lighting') as $item)
                    <x-spotlight-card
                        :title="$item['title']"
                        :description="$item['description']"
                        :image="$item['image']"
                        :url="route('shop', ['category' => 'continuous-light'])"
                    />
                @endforeach
            </div>
        </div>
    </section>

    <x-brand-strip />

    <x-product-tabs :tabs="$productTabs" :panels="$productPanels" />

    <section class="home-section border-t border-gray-200">
        <div class="container-site flex flex-col items-start justify-between gap-5 py-10 md:flex-row md:items-center">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Need help choosing gear?</h2>
                <p class="mt-1 text-sm text-gray-600">Call {{ config('site.contact.phone_display') }} or read our <a href="{{ route('help') }}" class="text-primary hover:underline">rental guide</a>.</p>
            </div>
            <a href="{{ route('contact') }}" class="btn-solid">Contact us</a>
        </div>
    </section>
@endsection
