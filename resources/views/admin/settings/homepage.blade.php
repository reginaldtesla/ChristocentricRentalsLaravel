@extends('layouts.admin')

@section('title', 'Homepage')

@section('content')
    <div class="admin-editor" data-homepage-editor>
        <div class="admin-editor-intro">
            <p>Edit what visitors see on your homepage. Expand a card to edit it, use <strong>Add</strong> to create more, or <strong>Remove</strong> to delete. Save once at the bottom when finished.</p>
            <a href="{{ route('home') }}" target="_blank" rel="noopener" class="admin-editor-preview-link">Open homepage in new tab ↗</a>
        </div>

        <nav class="admin-editor-nav" aria-label="Homepage sections">
            <a href="#homepage-hero" class="admin-editor-nav-link">Top banner</a>
            <a href="#homepage-highlights" class="admin-editor-nav-link">Highlights</a>
            <a href="#homepage-categories" class="admin-editor-nav-link">Categories</a>
            <a href="#homepage-picks" class="admin-editor-nav-link">Staff picks</a>
            <a href="#homepage-lighting" class="admin-editor-nav-link">Lighting</a>
        </nav>

        <form id="homepage-form" action="{{ route('admin.settings.homepage.update') }}" method="POST" enctype="multipart/form-data" class="admin-editor-form">
            @csrf
            @method('PUT')

            <section id="homepage-hero" class="admin-editor-section">
                <header class="admin-editor-section-head">
                    <div>
                        <h2 class="admin-editor-section-title">Top banner carousel</h2>
                        <p class="admin-editor-section-desc">Large rotating slides at the very top of the homepage.</p>
                    </div>
                    <span class="admin-editor-section-count" data-editor-count>{{ count($heroSlides) }} slides</span>
                </header>
                <div
                    class="admin-editor-items"
                    data-editor-list
                    data-editor-prefix="hero_slides"
                    data-editor-label="Slide"
                    data-editor-template="tpl-hero-slide"
                    data-editor-singular="slide"
                    data-editor-max="12"
                >
                    @foreach ($heroSlides as $index => $slide)
                        @include('admin.settings.homepage.partials.hero-item', ['index' => $index, 'item' => $slide, 'open' => $index === 0])
                    @endforeach
                </div>
                <button type="button" class="admin-editor-add-btn" data-editor-add>Add slide</button>
            </section>

            <section id="homepage-highlights" class="admin-editor-section">
                <header class="admin-editor-section-head">
                    <div>
                        <h2 class="admin-editor-section-title">Highlighted this week</h2>
                        <p class="admin-editor-section-desc">Promo carousel below “Popular right now”.</p>
                    </div>
                    <span class="admin-editor-section-count" data-editor-count>{{ count($dealsSlides) }} highlights</span>
                </header>
                <div
                    class="admin-editor-items"
                    data-editor-list
                    data-editor-prefix="deals_slides"
                    data-editor-label="Highlight"
                    data-editor-template="tpl-highlight-item"
                    data-editor-singular="highlight"
                    data-editor-max="12"
                >
                    @foreach ($dealsSlides as $index => $slide)
                        @include('admin.settings.homepage.partials.highlight-item', ['index' => $index, 'item' => $slide, 'open' => $index === 0])
                    @endforeach
                </div>
                <button type="button" class="admin-editor-add-btn" data-editor-add>Add highlight</button>
            </section>

            <section id="homepage-categories" class="admin-editor-section">
                <header class="admin-editor-section-head">
                    <div>
                        <h2 class="admin-editor-section-title">Browse by category</h2>
                        <p class="admin-editor-section-desc">Cards in the “Browse by category” grid.</p>
                    </div>
                    <span class="admin-editor-section-count" data-editor-count>{{ count($brandBanners) }} cards</span>
                </header>
                <div
                    class="admin-editor-items"
                    data-editor-list
                    data-editor-prefix="brand_banners"
                    data-editor-label="Card"
                    data-editor-template="tpl-category-item"
                    data-editor-singular="card"
                    data-editor-max="12"
                >
                    @foreach ($brandBanners as $index => $banner)
                        @include('admin.settings.homepage.partials.category-item', ['index' => $index, 'item' => $banner])
                    @endforeach
                </div>
                <button type="button" class="admin-editor-add-btn" data-editor-add>Add category card</button>
            </section>

            <section id="homepage-picks" class="admin-editor-section">
                <header class="admin-editor-section-head">
                    <div>
                        <h2 class="admin-editor-section-title">Staff picks</h2>
                        <p class="admin-editor-section-desc">Featured cards with large photos.</p>
                    </div>
                    <span class="admin-editor-section-count" data-editor-count>{{ count($weeklyDeals) }} picks</span>
                </header>
                <div
                    class="admin-editor-items"
                    data-editor-list
                    data-editor-prefix="weekly_deals"
                    data-editor-label="Pick"
                    data-editor-template="tpl-pick-item"
                    data-editor-singular="pick"
                    data-editor-max="12"
                >
                    @foreach ($weeklyDeals as $index => $deal)
                        @include('admin.settings.homepage.partials.pick-item', ['index' => $index, 'item' => $deal])
                    @endforeach
                </div>
                <button type="button" class="admin-editor-add-btn" data-editor-add>Add staff pick</button>
            </section>

            <section id="homepage-lighting" class="admin-editor-section">
                <header class="admin-editor-section-head">
                    <div>
                        <h2 class="admin-editor-section-title">Lighting &amp; grip</h2>
                        <p class="admin-editor-section-desc">Small spotlight tiles in the lighting section.</p>
                    </div>
                    <span class="admin-editor-section-count" data-editor-count>{{ count($featuredLighting) }} items</span>
                </header>
                <div
                    class="admin-editor-items"
                    data-editor-list
                    data-editor-prefix="featured_lighting"
                    data-editor-label="Item"
                    data-editor-template="tpl-lighting-item"
                    data-editor-singular="item"
                    data-editor-max="12"
                >
                    @foreach ($featuredLighting as $index => $item)
                        @include('admin.settings.homepage.partials.lighting-item', ['index' => $index, 'item' => $item])
                    @endforeach
                </div>
                <button type="button" class="admin-editor-add-btn" data-editor-add>Add lighting item</button>
            </section>
        </form>

        <template id="tpl-hero-slide">
            @include('admin.settings.homepage.partials.hero-item', ['index' => '__INDEX__', 'item' => [], 'open' => true])
        </template>
        <template id="tpl-highlight-item">
            @include('admin.settings.homepage.partials.highlight-item', ['index' => '__INDEX__', 'item' => [], 'open' => true])
        </template>
        <template id="tpl-category-item">
            @include('admin.settings.homepage.partials.category-item', ['index' => '__INDEX__', 'item' => [], 'open' => true])
        </template>
        <template id="tpl-pick-item">
            @include('admin.settings.homepage.partials.pick-item', ['index' => '__INDEX__', 'item' => [], 'open' => true])
        </template>
        <template id="tpl-lighting-item">
            @include('admin.settings.homepage.partials.lighting-item', ['index' => '__INDEX__', 'item' => [], 'open' => true])
        </template>

        <div class="admin-editor-savebar">
            <p class="admin-editor-savebar-text">When you’re done editing, save all homepage sections at once.</p>
            <button type="submit" form="homepage-form" class="btn-solid admin-editor-savebar-btn">Save homepage</button>
        </div>
    </div>
@endsection
