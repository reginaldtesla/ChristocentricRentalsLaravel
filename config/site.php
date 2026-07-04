<?php

return [

    'currency_symbol' => '₵',

    'rental_defaults' => [
        'pickup_time' => '09:00',
        'return_time' => '17:00',
    ],

    'rental_penalties' => [
        'grace_minutes' => 30,
        'daily_rate_multiplier' => 1,
        'due_soon_hours' => 24,
    ],

    'clone_path' => env('CLONE_PATH', 'C:\\Users\\RegiTes\\Downloads\\Chris\\christocentricrentals.com'),

    'trending_searches' => ['canon', 'Sony', 'sigma'],

    'utility_links' => [
        ['label' => 'Store Locator', 'route' => 'contact'],
        ['label' => 'Newsletter', 'route' => 'home', 'hash' => '#newsletter'],
        ['label' => 'Contact Us', 'route' => 'contact'],
        ['label' => 'FAQs', 'route' => 'faq'],
    ],

    'trust_features' => [
        ['title' => 'Pickup in Kumasi', 'subtitle' => 'Bomso, near Abesse Gaming Center'],
        ['title' => 'Book ahead', 'subtitle' => 'reserve gear for your shoot dates'],
        ['title' => 'Gear support', 'subtitle' => 'help before and during your rental'],
        ['title' => 'Maintained inventory', 'subtitle' => 'cleaned and tested before every hire'],
    ],

    'brands' => [
        'Canon', 'Sony', 'Sigma', 'DJI', 'Aputure', 'Godox', 'RØDE', 'Blackmagic',
        'Nikon', 'Tamron', 'SanDisk', 'SmallRig', 'Zhiyun', 'Amaran',
    ],

    'footer_features' => [
        ['title' => 'Pickup & returns', 'subtitle' => 'Bomso, Kumasi — near Abesse Gaming Center'],
        ['title' => 'Card & mobile pay', 'subtitle' => 'Visa, Mastercard, mobile money & more'],
        ['title' => 'Rental support', 'subtitle' => 'support@christocentricrentals.com'],
        ['title' => 'Response within 24hrs', 'subtitle' => 'on business days'],
    ],

    'newsletter' => [
        'eyebrow' => 'Stay in the loop',
        'heading' => 'New gear drops & rental tips, straight to your inbox',
        'subtext' => 'Be first to know when cameras, lenses and lighting kits land in our Kumasi inventory.',
        'button' => 'Join newsletter',
        'privacy_note' => 'No spam — unsubscribe anytime. See our',
        'founder_name' => 'Christocentric Rentals',
        'founder_role' => 'Kumasi, Ghana',
        'founder_quote' => 'We don’t just hand over equipment — we help creators, churches and production teams get the right gear for the job. Whether it’s your first short film or a full commercial shoot, we’re here before pickup and after return.',
        'founder_avatar' => 'brand/icon.png',
    ],

    'contact' => [
        'email' => 'info@christocentricrentals.com',
        'support_email' => 'support@christocentricrentals.com',
        'feedback_email' => 'feedback@christocentricrentals.com',
        'phone' => '+233532670582',
        'phone_display' => '(+233) 532 670 582',
        'address' => 'Bomso, near Abesse Gaming Center',
        'city' => 'Kumasi, Ghana',
    ],

    'categories' => [
        ['name' => 'Projectors', 'slug' => 'projectors'],
        ['name' => 'Cameras', 'slug' => 'cameras'],
        ['name' => 'Lens', 'slug' => 'lens'],
        ['name' => 'Canon Cameras', 'slug' => 'canon-cameras'],
        ['name' => 'Canon Lenses', 'slug' => 'canon-lenses'],
        ['name' => 'Sony Cameras', 'slug' => 'sony-cameras'],
        ['name' => 'Sony Lenses', 'slug' => 'sony-lenses'],
        ['name' => 'Sigma Lenses', 'slug' => 'sigma-lenses'],
        ['name' => 'Continuous Light', 'slug' => 'continuous-light'],
        ['name' => 'Gimbals', 'slug' => 'gimbals'],
        ['name' => 'Drone', 'slug' => 'drone'],
        ['name' => 'Audio Gears', 'slug' => 'audio-gears'],
        ['name' => 'Accessories', 'slug' => 'accessories'],
        ['name' => 'New Arrivals', 'slug' => 'new-arrivals'],
    ],

    'hero_slides' => [
        [
            'subtitle' => 'Cameras',
            'title' => 'Canon EOS R5',
            'description' => '8K video and 45MP stills — available for daily and weekly hire from our Kumasi inventory.',
            'image' => 'storage/2024/10/eos-r5_2-1.webp',
            'cta_primary' => 'Browse cameras',
            'cta_url' => '/shop?category=cameras',
        ],
        [
            'subtitle' => 'Lighting',
            'title' => 'Continuous LED kits',
            'description' => 'Tolifo, Aputure and Godox panels for location work, interviews and studio setups.',
            'image' => 'storage/2024/10/h0e6e4d4673d146bfb25afd58185411a79-png-720x720q50-879f19c4-f13b-43e2-aa86-c6f01a658009-b0c844d6-dc21-44aa-88e0-265b50bee175-300x300.webp',
            'cta_primary' => 'Browse lights',
            'cta_url' => '/shop?category=continuous-light',
        ],
        [
            'subtitle' => 'Stabilizers',
            'title' => 'Gimbals & supports',
            'description' => 'Zhiyun, DJI Ronin and more for smooth handheld and run-and-gun shoots.',
            'image' => 'storage/2024/10/download.jpeg',
            'cta_primary' => 'Browse gimbals',
            'cta_url' => '/shop?category=gimbals',
        ],
        [
            'subtitle' => 'Aerial',
            'title' => 'Drones & action cams',
            'description' => 'DJI and related gear for aerial footage and on-the-go production.',
            'image' => 'storage/2024/10/9d-300x300.jpg',
            'cta_primary' => 'Browse drones',
            'cta_url' => '/shop?category=drone',
        ],
    ],

    'deals_slides' => [
        [
            'badge' => 'Just in',
            'title' => 'Canon R6 Mark II',
            'before' => 'Full-frame hybrid body — strong choice for photo and video crews.',
            'image' => 'storage/2024/10/5666C002_eos_r6_mark_ii_body_primary-300x300.webp',
            'url' => '/shop?category=canon-cameras',
        ],
        [
            'badge' => 'Lighting',
            'title' => 'Tolifo KW-200B',
            'before' => 'Bi-color LED panels suited to interviews and small location sets.',
            'image' => 'storage/2024/10/den-led-tolifo-kw-200b-4-300x300.jpg',
            'url' => '/shop?category=continuous-light',
        ],
        [
            'badge' => 'Lenses',
            'title' => 'Canon 70–200mm f/2.8',
            'before' => 'A reliable telephoto zoom for events, sports and portraits.',
            'image' => 'storage/2024/10/CANON-LENS-EF70-200MM-5-300x300.jpg',
            'url' => '/shop?category=lens',
        ],
    ],

    'brand_banners' => [
        [
            'title' => 'Canon cameras',
            'description' => 'R5, R6, 5D and more',
            'image' => 'storage/2024/10/eos-r5_2-1-300x300.webp',
            'url' => '/shop?category=canon-cameras',
        ],
        [
            'title' => 'LED lighting',
            'description' => 'Panels, tubes and kits',
            'image' => 'storage/2024/10/den-led-tolifo-kw-200b-4-300x300.jpg',
            'url' => '/shop?category=continuous-light',
        ],
        [
            'title' => 'Drones',
            'description' => 'DJI aerial kits',
            'image' => 'storage/2024/10/9d-300x300.jpg',
            'url' => '/shop?category=drone',
        ],
        [
            'title' => 'Lenses',
            'description' => 'Canon, Sony, Sigma',
            'image' => 'storage/2024/10/CANON-LENS-EF70-200MM-5-300x300.jpg',
            'url' => '/shop?category=lens',
        ],
    ],

    'weekly_deals' => [
        [
            'title' => 'Canon R6 Mark II body',
            'description' => 'Hybrid stills and video for demanding shoots.',
            'image' => 'storage/2024/10/5666C002_eos_r6_mark_ii_body_primary-300x300.webp',
            'url' => '/shop?category=canon-cameras',
        ],
        [
            'title' => 'Wireless audio',
            'description' => 'Transmitters and lav kits for clean location sound.',
            'image' => 'storage/2024/10/9d-300x300.jpg',
            'url' => '/shop?category=audio-gears',
        ],
        [
            'title' => 'Sony cinema bodies',
            'description' => 'FX and Alpha lines for production crews.',
            'image' => 'storage/2025/02/Sony-comera.jpeg',
            'url' => '/shop?category=sony-cameras',
        ],
    ],

    'featured_lighting' => [
        ['title' => 'Aputure panels', 'description' => 'Daylight and bi-color options.', 'image' => 'storage/2024/10/den-led-tolifo-kw-200b-4-300x300.jpg'],
        ['title' => 'Tolifo KW series', 'description' => 'Compact panels for run-and-gun.', 'image' => 'storage/2024/10/h0e6e4d4673d146bfb25afd58185411a79-png-720x720q50-879f19c4-f13b-43e2-aa86-c6f01a658009-b0c844d6-dc21-44aa-88e0-265b50bee175-300x300.webp'],
        ['title' => 'Strobe kits', 'description' => 'Selected flash heads and modifiers.', 'image' => 'storage/2024/10/9d-300x300.jpg'],
        ['title' => 'Amaran 300c', 'description' => 'RGBWW fixture for creative lighting.', 'image' => 'storage/2024/10/5666C002_eos_r6_mark_ii_body_primary-300x300.webp'],
    ],

];
