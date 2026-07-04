<?php

namespace App\Support;

class ProductCatalog
{
    /**
     * @return list<array<string, mixed>>
     */
    public static function all(): array
    {
        $products = [
            ['slug' => 'canon-r5-body-only', 'name' => 'Canon R5 (Body only)', 'price' => 400.00, 'image' => 'products/eos-r5_2-1-300x300.webp', 'category' => 'Canon Cameras', 'category_slug' => 'canon-cameras', 'excerpt' => 'Flagship full-frame mirrorless with 45MP sensor and 8K video for professional cinema work.', 'is_new' => true, 'is_featured' => true, 'rating' => 5],
            ['slug' => 'canon-r6-mark-ii-body-only', 'name' => 'Canon R6 Mark II (Body only)', 'price' => 400.00, 'image' => 'products/5666C002_eos_r6_mark_ii_body_primary-300x300.webp', 'category' => 'Canon Cameras', 'category_slug' => 'canon-cameras', 'excerpt' => 'Versatile hybrid shooter with excellent autofocus and low-light performance for events and film.', 'is_new' => true, 'is_featured' => true, 'rating' => 5],
            ['slug' => 'canon-r6-with-ef-adaptor', 'name' => 'Canon R6 with EF Adaptor', 'price' => 400.00, 'image' => 'products/CanonEOSR6adapter-1-300x300.jpg', 'category' => 'Canon Cameras', 'category_slug' => 'canon-cameras', 'excerpt' => 'Canon R6 body bundled with EF lens adapter for your existing Canon glass.', 'is_new' => false, 'is_featured' => true, 'rating' => 4],
            ['slug' => 'canon-r-with-adaptor', 'name' => 'Canon R with Adaptor', 'price' => 350.00, 'image' => 'products/EOS-R-with-adapter1-300x300.jpg', 'category' => 'Canon Cameras', 'category_slug' => 'canon-cameras', 'excerpt' => 'The first step in Canon\'s mirrorless evolution with redeveloped RF mount compatibility.', 'is_new' => false, 'is_featured' => false, 'rating' => 4],
            ['slug' => 'canon-5d-mark-iv', 'name' => 'Canon 5D Mark IV', 'price' => 250.00, 'image' => 'products/9d-300x300.jpg', 'category' => 'Canon Cameras', 'category_slug' => 'canon-cameras', 'excerpt' => 'Reliable DSLR workhorse trusted for weddings, documentaries, and commercial shoots.', 'is_new' => false, 'is_featured' => true, 'rating' => 5],
            ['slug' => 'canon-5d-mark-iii', 'name' => 'Canon 5D Mark III', 'price' => 200.00, 'image' => 'products/Canon-5D-mark-III-570x570-1-300x300.webp', 'category' => 'Canon Cameras', 'category_slug' => 'canon-cameras', 'excerpt' => 'Industry-standard DSLR that still delivers beautiful stills and video on a budget.', 'is_new' => false, 'is_featured' => false, 'rating' => 4],
            ['slug' => 'canon-6d-mark-ii', 'name' => 'Canon 6D Mark II', 'price' => 200.00, 'image' => 'products/maek-ii-300x300.jpg', 'category' => 'Canon Cameras', 'category_slug' => 'canon-cameras', 'excerpt' => 'Full-frame DSLR with articulating screen, ideal for vloggers and portrait photographers.', 'is_new' => false, 'is_featured' => false, 'rating' => 4],
            ['slug' => 'canon-6d', 'name' => 'Canon 6D', 'price' => 160.00, 'image' => 'products/1457377470_892349-300x300-1.jpg', 'category' => 'Canon Cameras', 'category_slug' => 'canon-cameras', 'excerpt' => 'Affordable full-frame entry for creators stepping up from crop-sensor bodies.', 'is_new' => false, 'is_featured' => false, 'rating' => 3],
            ['slug' => 'canon-80d', 'name' => 'Canon 80D', 'price' => 150.00, 'image' => 'products/EOS80D_b1-300x300.png', 'category' => 'Canon Cameras', 'category_slug' => 'canon-cameras', 'excerpt' => 'Capable APS-C DSLR with fast dual-pixel AF for run-and-gun video and photography.', 'is_new' => false, 'is_featured' => false, 'rating' => 4],
            ['slug' => 'canon-70-200mm-f-2-8-iii', 'name' => 'Canon 70-200mm f/2.8 III', 'price' => 230.00, 'image' => 'products/CANON-LENS-EF70-200MM-5-300x300.jpg', 'category' => 'Canon Lenses', 'category_slug' => 'lens', 'excerpt' => 'One of the most versatile telephoto zooms for sports, weddings, and portraits.', 'is_new' => false, 'is_featured' => true, 'rating' => 5],
        ];

        return array_map(fn (array $product) => array_merge([
            'in_stock' => true,
        ], $product), $products);
    }

    public static function featured(int $limit = 8): array
    {
        return array_slice(
            array_values(array_filter(self::all(), fn ($p) => $p['is_featured'])),
            0,
            $limit
        );
    }

    public static function newest(int $limit = 6): array
    {
        return array_slice(
            array_values(array_filter(self::all(), fn ($p) => $p['is_new'])),
            0,
            $limit
        );
    }

    public static function topRated(int $limit = 6): array
    {
        $products = self::all();
        usort($products, fn ($a, $b) => $b['rating'] <=> $a['rating']);

        return array_slice($products, 0, $limit);
    }

    public static function widgetLists(): array
    {
        $all = self::all();

        return [
            'new' => array_slice(array_values(array_filter($all, fn ($p) => $p['is_new'])), 0, 3),
            'featured' => array_slice(array_values(array_filter($all, fn ($p) => $p['is_featured'])), 0, 3),
            'best_week' => self::topRated(3),
            'popular' => array_slice($all, -3),
        ];
    }

    /**
     * @return list<array<string, mixed>>
     */
    public static function byCategory(?string $categorySlug): array
    {
        if ($categorySlug === null || $categorySlug === '') {
            return self::all();
        }

        $categoryMap = [
            'cameras' => ['canon-cameras', 'sony-cameras', 'video-cameras'],
        ];

        $slugs = $categoryMap[$categorySlug] ?? [$categorySlug];

        return array_values(array_filter(
            self::all(),
            fn (array $product) => in_array($product['category_slug'], $slugs, true)
        ));
    }

    /**
     * @return list<array<string, mixed>>
     */
    public static function search(?string $query, ?string $categorySlug): array
    {
        $products = self::byCategory($categorySlug);

        if ($query === null || trim($query) === '') {
            return $products;
        }

        $needle = strtolower(trim($query));

        return array_values(array_filter(
            $products,
            fn (array $product) => str_contains(strtolower($product['name']), $needle)
                || str_contains(strtolower($product['category']), $needle)
        ));
    }

    public static function formatPrice(float $price): string
    {
        return config('site.currency_symbol').number_format($price, 2);
    }
}
