<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Support\ProductImage;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class RenameProductImages extends Command
{
    protected $signature = 'images:rename-products
                            {--slug= : Rename a single product}
                            {--force : Overwrite existing descriptive files}';

    protected $description = 'Copy product images into storage/products/{slug}.{ext} with readable filenames';

    public function handle(): int
    {
        $query = Product::query()->whereNotNull('image');

        if ($slug = $this->option('slug')) {
            $query->where('slug', $slug);
        }

        $products = $query->get();

        if ($products->isEmpty()) {
            $this->warn('No products matched.');

            return self::SUCCESS;
        }

        $this->info("Renaming images for {$products->count()} product(s)...");

        $renamed = 0;
        $skipped = 0;
        $failed = 0;

        foreach ($products as $product) {
            $fileSlug = $this->fileSlugFor($product);
            $sourcePath = ProductImage::pathForSlug($product->slug, $product->image);

            if (ProductImage::usesDescriptiveFilename($fileSlug, $product->image) && ! $this->option('force')) {
                $skipped++;
                $this->line("  skip {$product->slug} (already {$product->image})");

                continue;
            }

            $destPath = ProductImage::materializeDescriptivePath(
                $fileSlug,
                $sourcePath,
                (bool) $this->option('force'),
            );

            if ($destPath === null) {
                $this->warn("  failed {$product->slug}: could not materialize image");
                $failed++;

                continue;
            }

            if ($product->image !== $destPath) {
                $product->update(['image' => $destPath]);
            }

            $renamed++;
            $this->line("  {$product->slug} → {$destPath}");
        }

        $this->newLine();
        $this->info("Done. Renamed: {$renamed}, skipped: {$skipped}, failed: {$failed}.");

        return $failed > 0 ? self::FAILURE : self::SUCCESS;
    }

    public function fileSlugFor(Product $product): string
    {
        if ($product->slug === '__trashed' || $product->slug === '') {
            return Str::slug($product->name);
        }

        return $product->slug;
    }
}
