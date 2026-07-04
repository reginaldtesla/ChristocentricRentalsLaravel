<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class SyncAssetsFromClone extends Command
{
    protected $signature = 'assets:sync-clone {path? : Path to the static WordPress clone}';

    protected $description = 'Copy storage images from the clone and fix product image paths';

    public function handle(): int
    {
        $clonePath = $this->argument('path')
            ?? config('site.clone_path');

        if (! is_dir($clonePath)) {
            $this->error("Clone path not found: {$clonePath}");

            return self::FAILURE;
        }

        $storageSource = $clonePath.DIRECTORY_SEPARATOR.'storage';
        $storageDest = public_path('images/storage');

        if (! is_dir($storageSource)) {
            $this->error('No storage folder found in clone.');

            return self::FAILURE;
        }

        $this->info('Copying storage images (2022–2025)...');
        $copied = 0;

        foreach (['2022', '2023', '2024', '2025'] as $year) {
            $yearSource = $storageSource.DIRECTORY_SEPARATOR.$year;
            if (! is_dir($yearSource)) {
                continue;
            }

            $yearDest = $storageDest.DIRECTORY_SEPARATOR.$year;
            File::ensureDirectoryExists($yearDest);
            $copied += $this->copyDirectory($yearSource, $yearDest);
        }

        $placeholder = $storageSource.DIRECTORY_SEPARATOR.'woocommerce-placeholder-300x300.png';
        if (file_exists($placeholder)) {
            File::ensureDirectoryExists($storageDest);
            File::copy($placeholder, $storageDest.DIRECTORY_SEPARATOR.'woocommerce-placeholder-300x300.png');
            $copied++;
        }

        $logoSource = $storageSource.DIRECTORY_SEPARATOR.'2024'.DIRECTORY_SEPARATOR.'10'.DIRECTORY_SEPARATOR.'cropped-Christocentric-Rentals-logo-3.png';
        if (file_exists($logoSource)) {
            File::ensureDirectoryExists(public_path('images/brand'));
            File::copy($logoSource, public_path('images/brand/logo.png'));
            $copied++;
        }

        $this->info("Copied {$copied} image files.");

        $this->info('Updating product image paths from clone HTML...');
        $updated = $this->fixProductImages($clonePath);
        $this->info("Updated {$updated} product image paths.");

        $this->newLine();
        $this->info('Renaming product images to descriptive filenames...');
        $this->call('images:rename-products');

        return self::SUCCESS;
    }

    private function copyDirectory(string $source, string $dest): int
    {
        $count = 0;

        foreach (File::allFiles($source) as $file) {
            if (! preg_match('/\.(jpe?g|png|webp|gif|svg|avif)$/i', $file->getFilename())) {
                continue;
            }

            $relative = $file->getRelativePathname();
            $target = $dest.DIRECTORY_SEPARATOR.$relative;

            File::ensureDirectoryExists(dirname($target));

            if (! file_exists($target) || filemtime($file->getPathname()) > filemtime($target)) {
                File::copy($file->getPathname(), $target);
                $count++;
            }
        }

        return $count;
    }

    private function fixProductImages(string $clonePath): int
    {
        $updated = 0;

        foreach (glob($clonePath.'/product/*/index.html') ?: [] as $file) {
            $slug = basename(dirname($file));

            $html = file_get_contents($file);

            $imagePath = $this->extractPrimaryImage($html);

            if (! $imagePath) {
                continue;
            }

            $product = Product::where('slug', $slug)->first();

            if (! $product) {
                continue;
            }

            $needsUpdate = $product->image !== $imagePath
                || \App\Support\ProductImage::isBrandImage((string) $product->image);

            if ($needsUpdate) {
                $product->update(['image' => $imagePath]);
                $updated++;
            }
        }

        // Fix legacy products/* paths by matching filename in storage
        foreach (Product::where('image', 'like', 'products/%')->get() as $product) {
            $basename = basename($product->image);
            $match = $this->findStorageFile($basename);

            if ($match) {
                $product->update(['image' => $match]);
                $updated++;
            }
        }

        // Store the largest available file path, not the thumbnail.
        foreach (Product::whereNotNull('image')->get() as $product) {
            $canonical = \App\Support\ProductImage::canonicalStoragePath($product->image);

            if ($canonical !== $product->image && $canonical !== \App\Support\ProductImage::PLACEHOLDER) {
                $product->update(['image' => $canonical]);
                $updated++;
            }
        }

        return $updated;
    }

    private function findStorageFile(string $basename): ?string
    {
        $storageRoot = public_path('images/storage');

        foreach (['2025', '2024', '2023', '2022'] as $year) {
            $yearPath = $storageRoot.DIRECTORY_SEPARATOR.$year;
            if (! is_dir($yearPath)) {
                continue;
            }

            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($yearPath, \FilesystemIterator::SKIP_DOTS)
            );

            foreach ($iterator as $file) {
                if ($file->getFilename() === $basename) {
                    $relative = str_replace('\\', '/', substr($file->getPathname(), strlen($storageRoot) + 1));

                    return 'storage/'.$relative;
                }
            }
        }

        return null;
    }

    private function extractPrimaryImage(string $html): ?string
    {
        return \App\Support\ProductImage::extractFromProductHtml($html);
    }

    private function extractBestImageFromHtml(string $html): ?string
    {
        return \App\Support\ProductImage::extractFromProductHtml($html);
    }

    private function preferThumbnailPath(string $relative): string
    {
        $path = 'storage/'.$relative;

        if (file_exists(public_path('images/'.$path))) {
            return $path;
        }

        return \App\Support\ProductImage::canonicalStoragePath($path);
    }
}
