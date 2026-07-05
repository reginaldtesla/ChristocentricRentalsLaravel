<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use App\Support\ProductCategoryGuess;
use App\Support\ProductDescriptions;
use App\Support\ProductImage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImportProductsFromImages extends Command
{
    protected $signature = 'catalog:import-images
                            {--apply-descriptions : Apply ProductDescriptions after import}
                            {--default-price=150 : Default daily rental price when unknown}';

    protected $description = 'Import products from slug-based images in public/images/storage/products (no clone required)';

    public function handle(): int
    {
        $productsDir = public_path('images/'.ProductImage::productsDir());

        if (! is_dir($productsDir)) {
            $this->error("Products image directory not found: {$productsDir}");

            return self::FAILURE;
        }

        $descriptions = ProductDescriptions::all();
        $defaultPrice = (float) $this->option('default-price');
        $imported = 0;
        $updated = 0;

        foreach (File::files($productsDir) as $file) {
            $filename = $file->getFilename();

            if (preg_match('/-cutout\./i', $filename)) {
                continue;
            }

            $extension = strtolower($file->getExtension());

            if (! in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'avif', 'gif'], true)) {
                continue;
            }

            $slug = pathinfo($filename, PATHINFO_FILENAME);
            $imagePath = ProductImage::productsDir().'/'.$filename;
            $categorySlug = ProductCategoryGuess::fromSlug($slug);
            $categoryId = Category::where('slug', $categorySlug)->value('id')
                ?? Category::where('slug', 'accessories')->value('id');

            $entry = $descriptions[$slug] ?? null;
            $name = $this->displayName($slug);
            $excerpt = $entry['excerpt'] ?? Str::limit($name.' — professional rental gear.', 200);
            $description = $entry['description'] ?? $name;

            $product = Product::query()->where('slug', $slug)->first();
            $attributes = [
                'category_id' => $categoryId,
                'name' => $name,
                'excerpt' => $excerpt,
                'description' => $description,
                'price_per_day' => $product?->price_per_day ?? $defaultPrice,
                'image' => $imagePath,
                'in_stock' => true,
                'rating' => $product?->rating ?? 4,
                'is_new' => $product?->is_new ?? false,
                'is_featured' => $product?->is_featured ?? false,
            ];

            Product::query()->updateOrCreate(['slug' => $slug], $attributes);

            if ($product === null) {
                $imported++;
            } else {
                $updated++;
            }
        }

        $total = Product::query()->count();
        $this->info("Imported {$imported} new product(s), refreshed {$updated} existing product(s).");
        $this->info("Catalog total: {$total} product(s).");

        if ($this->option('apply-descriptions')) {
            $this->newLine();
            $this->call('catalog:apply-descriptions');
        }

        return self::SUCCESS;
    }

    private function displayName(string $slug): string
    {
        $name = str_replace(['-body-only', '-with-ef-adaptor'], [' (Body only)', ' with EF Adaptor'], $slug);
        $name = preg_replace('/\bf-(\d+(?:-\d+)?)/', 'f/$1', $name) ?? $name;
        $name = preg_replace('/(\d+)mm/', '$1mm', $name) ?? $name;

        return Str::title(str_replace('-', ' ', $name));
    }
}
