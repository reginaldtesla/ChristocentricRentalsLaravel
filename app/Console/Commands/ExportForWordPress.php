<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use App\Models\SiteSetting;
use App\Support\ProductDescriptions;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ExportForWordPress extends Command
{
    protected $signature = 'catalog:export-wordpress
        {--output= : Output directory (default: ../ChristoCentricRentalsWordpress/migration)}
        {--copy-images : Copy product images into migration/images}';

    protected $description = 'Export Laravel catalog and settings for WordPress / WooCommerce import (does not modify Laravel data)';

    public function handle(): int
    {
        $output = $this->option('output')
            ?: base_path('../ChristoCentricRentalsWordpress/migration');

        File::ensureDirectoryExists($output);
        File::ensureDirectoryExists($output.'/images');

        $this->exportProductsCsv($output);
        $this->exportCategoriesJson($output);
        $this->exportSiteSettingsJson($output);
        $this->exportPageDefaults($output);

        if ($this->option('copy-images')) {
            $this->copyImages($output);
        }

        $this->info("WordPress export written to: {$output}");
        $this->line('Next: run WordPress setup, import woocommerce-products.csv via WooCommerce → Products → Import');

        return self::SUCCESS;
    }

    private function exportProductsCsv(string $output): void
    {
        $path = $output.'/woocommerce-products.csv';
        $handle = fopen($path, 'w');

        fputcsv($handle, [
            'ID', 'Type', 'SKU', 'Name', 'Published', 'Is featured?', 'Visibility in catalog',
            'Short description', 'Description', 'Tax status', 'In stock?', 'Stock', 'Regular price',
            'Categories', 'Tags', 'Images', 'Meta: _ccr_price_per_day', 'Meta: _ccr_is_featured',
            'Meta: _ccr_is_new', 'Meta: _ccr_rating', 'Meta: _ccr_rentopian_id', 'Meta: _ccr_laravel_slug',
        ]);

        $descriptions = ProductDescriptions::all();

        Product::query()->with('category')->orderBy('name')->each(function (Product $product) use ($handle, $descriptions) {
            $desc = $descriptions[$product->slug] ?? null;
            $description = $desc['description'] ?? $product->description ?? '';
            $excerpt = $desc['excerpt'] ?? $product->excerpt ?? '';

            $imageUrl = '';
            if ($product->image) {
                $imageUrl = 'images/'.ltrim(str_replace('\\', '/', $product->image), '/');
            }

            fputcsv($handle, [
                '',
                'simple',
                $product->slug,
                $product->name,
                $product->in_stock ? 1 : 0,
                $product->is_featured ? 1 : 0,
                'visible',
                $excerpt,
                $description,
                'none',
                $product->in_stock ? 1 : 0,
                max(1, (int) ($product->quantity ?: 1)),
                number_format((float) $product->price_per_day, 2, '.', ''),
                $product->category?->name ?? '',
                '',
                $imageUrl,
                number_format((float) $product->price_per_day, 2, '.', ''),
                $product->is_featured ? 'yes' : 'no',
                $product->is_new ? 'yes' : 'no',
                (int) $product->rating,
                $product->rentopian_id ?? '',
                $product->slug,
            ]);
        });

        fclose($handle);
        $count = Product::count();
        $this->info("Exported {$count} products → woocommerce-products.csv");
    }

    private function exportCategoriesJson(string $output): void
    {
        $categories = Category::query()->orderBy('sort_order')->orderBy('name')->get()->map(fn ($c) => [
            'name' => $c->name,
            'slug' => $c->slug,
            'sort_order' => $c->sort_order,
        ]);

        File::put($output.'/categories.json', json_encode($categories, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $this->info('Exported categories.json');
    }

    private function exportSiteSettingsJson(string $output): void
    {
        $settings = [];

        if (\Illuminate\Support\Facades\Schema::hasTable('site_settings')) {
            foreach (SiteSetting::query()->get() as $setting) {
                $settings[$setting->key] = $setting->value;
            }
        }

        $payload = [
            'laravel_config_defaults' => config('site'),
            'database_overrides' => $settings,
        ];

        File::put($output.'/site-settings.json', json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $this->info('Exported site-settings.json');
    }

    private function exportPageDefaults(string $output): void
    {
        $pagesDir = config_path('page_defaults');
        $target = $output.'/pages';

        File::ensureDirectoryExists($target);

        foreach (glob($pagesDir.'/*.php') ?: [] as $file) {
            $name = basename($file, '.php');
            $data = require $file;
            File::put($target.'/'.$name.'.json', json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }

        $this->info('Exported page defaults → migration/pages/');
    }

    private function copyImages(string $output): void
    {
        $sourceRoot = public_path('images');
        $targetRoot = $output.'/images';
        $copied = 0;

        Product::query()->whereNotNull('image')->each(function (Product $product) use ($sourceRoot, $targetRoot, &$copied) {
            $relative = ltrim(str_replace('\\', '/', $product->image), '/');
            $source = $sourceRoot.'/'.$relative;

            if (! is_file($source)) {
                return;
            }

            $target = $targetRoot.'/'.$relative;
            File::ensureDirectoryExists(dirname($target));
            File::copy($source, $target);
            $copied++;
        });

        foreach (['brand/logo.png', 'brand/icon.png'] as $brandFile) {
            $source = $sourceRoot.'/'.$brandFile;
            if (is_file($source)) {
                $target = $targetRoot.'/'.$brandFile;
                File::ensureDirectoryExists(dirname($target));
                File::copy($source, $target);
            }
        }

        $this->info("Copied {$copied} product images (+ brand assets if present)");
    }
}
