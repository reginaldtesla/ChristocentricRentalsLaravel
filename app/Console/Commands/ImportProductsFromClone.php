<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ImportProductsFromClone extends Command
{
    protected $signature = 'catalog:import-clone {path? : Path to static site clone}';

    protected $description = 'Import products from the WordPress static clone HTML';

    public function handle(): int
    {
        $clonePath = $this->argument('path')
            ?? config('site.clone_path');

        if (! is_dir($clonePath)) {
            $this->error("Clone path not found: {$clonePath}");

            return self::FAILURE;
        }

        $files = array_merge(
            glob($clonePath.'/shop/index.html') ?: [],
            glob($clonePath.'/shop/page/*/index.html') ?: [],
            glob($clonePath.'/product/*/index.html') ?: [],
        );

        $imported = 0;
        $seen = [];

        foreach ($files as $file) {
            $html = file_get_contents($file);

            if (preg_match_all(
                '/href="(?:\.\.\/)*product\/([^"\/]+)\/"[^>]*>.*?woocommerce-loop-product__title[^>]*>([^<]+)</s',
                $html,
                $matches,
                PREG_SET_ORDER
            )) {
                foreach ($matches as $match) {
                    $slug = $match[1];
                    $name = html_entity_decode(trim($match[2]), ENT_QUOTES | ENT_HTML5);

                    if (isset($seen[$slug])) {
                        continue;
                    }
                    $seen[$slug] = true;

                    $this->importProductFromListing($slug, $name, $html);
                    $imported++;
                }
            }

            if (str_contains($file, '/product/') && preg_match('/<h1[^>]*class="[^"]*product_title[^"]*"[^>]*>([^<]+)</', $html, $titleMatch)) {
                $slug = basename(dirname($file));
                if (isset($seen[$slug])) {
                    continue;
                }
                $seen[$slug] = true;
                $this->importProductDetail($slug, html_entity_decode(trim($titleMatch[1]), ENT_QUOTES | ENT_HTML5), $html);
                $imported++;
            }
        }

        $this->info("Imported/updated {$imported} products.");

        return self::SUCCESS;
    }

    private function importProductFromListing(string $slug, string $name, string $html): void
    {
        $price = $this->extractPrice($html, $slug) ?? 150.00;
        $image = $this->extractImage($html, $slug);
        $categorySlug = $this->guessCategorySlug($html, $slug);

        Product::updateOrCreate(
            ['slug' => $slug],
            [
                'category_id' => Category::where('slug', $categorySlug)->value('id'),
                'name' => $name,
                'excerpt' => Str::limit($name.' — professional rental gear.', 200),
                'description' => $name,
                'price_per_day' => $price,
                'image' => $image,
                'in_stock' => true,
                'is_new' => str_contains($html, 'product_cat-new-arrivals'),
                'is_featured' => false,
                'rating' => 4,
            ]
        );
    }

    private function importProductDetail(string $slug, string $name, string $html): void
    {
        $price = $this->extractPrice($html, $slug) ?? 150.00;
        $image = $this->extractImage($html, $slug);
        $description = '';

        if (preg_match('/class="woocommerce-product-details__short-description"[^>]*>(.*?)<\/div>/s', $html, $descMatch)) {
            $description = trim(strip_tags($descMatch[1]));
        }

        Product::updateOrCreate(
            ['slug' => $slug],
            [
                'category_id' => Category::where('slug', $this->guessCategorySlug($html, $slug))->value('id'),
                'name' => $name,
                'excerpt' => Str::limit($description ?: $name, 200),
                'description' => $description ?: $name,
                'price_per_day' => $price,
                'image' => $image,
                'in_stock' => ! str_contains($html, 'out-of-stock'),
                'rating' => 4,
            ]
        );
    }

    private function extractPrice(string $html, string $slug): ?float
    {
        $pattern = '/product\/'.preg_quote($slug, '/').'\/.*?<span class="woocommerce-Price-amount[^"]*"><bdi><span class="woocommerce-Price-currencySymbol">[^<]*<\/span>([\d,.]+)/s';

        if (preg_match($pattern, $html, $match)) {
            return (float) str_replace(',', '', $match[1]);
        }

        if (preg_match('/<span class="woocommerce-Price-currencySymbol">[^<]*<\/span>([\d,.]+)/', $html, $match)) {
            return (float) str_replace(',', '', $match[1]);
        }

        return null;
    }

    private function extractImage(string $html, string $slug): ?string
    {
        $pattern = '/product\/'.preg_quote($slug, '/').'\/.*?src="(?:\.\.\/)*storage\/([^"?]+\.(?:jpe?g|png|webp|avif))/is';

        if (preg_match($pattern, $html, $match)) {
            return 'storage/'.$match[1];
        }

        return null;
    }

    private function guessCategorySlug(string $html, string $slug): string
    {
        if (preg_match('/product_cat-([a-z0-9-]+)/', $html, $match)) {
            $slug = $match[1];
            if (Category::where('slug', $slug)->exists()) {
                return $slug;
            }
        }

        return 'accessories';
    }
}
