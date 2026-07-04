<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Support\ProductImage;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class RemoveImageBackgrounds extends Command
{
    protected $signature = 'images:remove-backgrounds
                            {--slug= : Process a single product slug}
                            {--limit= : Maximum number of products to process}
                            {--force : Rebuild cutouts even if they already exist}';

    protected $description = 'Generate transparent product cutouts from catalog images using rembg';

    public function handle(): int
    {
        $python = $this->pythonBinary();
        $script = base_path('scripts/remove_background.py');

        if (! is_file($script)) {
            $this->error('Missing scripts/remove_background.py');

            return self::FAILURE;
        }

        $probe = new Process([$python, '-c', 'import rembg']);
        $probe->setTimeout(120);
        $probe->run();

        if (! $probe->isSuccessful()) {
            $this->error('rembg is not installed. Run: pip install "rembg[cpu]" pillow');

            return self::FAILURE;
        }

        $query = Product::query()->whereNotNull('image');

        if ($slug = $this->option('slug')) {
            $query->where('slug', $slug);
        }

        if ($limit = $this->option('limit')) {
            $query->limit((int) $limit);
        }

        $products = $query->get();

        if ($products->isEmpty()) {
            $this->warn('No products matched.');

            return self::SUCCESS;
        }

        $this->info("Processing {$products->count()} product image(s)...");

        $processed = 0;
        $skipped = 0;
        $failed = 0;

        foreach ($products as $product) {
            $source = ProductImage::largestSourcePath(ProductImage::pathForSlug($product->slug, $product->image));
            $sourceAbsolute = public_path('images/'.$source);

            if (! is_file($sourceAbsolute)) {
                $this->warn("Missing source for {$product->slug}: {$source}");
                $failed++;

                continue;
            }

            $cutoutRelative = ProductImage::cutoutPathForStored(ProductImage::pathForSlug($product->slug, $product->image));
            $cutoutAbsolute = public_path('images/'.$cutoutRelative);

            if (is_file($cutoutAbsolute) && ! $this->option('force')) {
                $skipped++;
                $this->line("  skip {$product->slug}");

                continue;
            }

            $this->line("  cutout {$product->slug} (".basename($source).')');

            $process = new Process([
                $python,
                $script,
                $sourceAbsolute,
                $cutoutAbsolute,
            ]);
            $process->setTimeout(300);
            $process->run();

            if (! $process->isSuccessful()) {
                $this->error("  failed {$product->slug}: ".trim($process->getErrorOutput() ?: $process->getOutput()));
                $failed++;

                continue;
            }

            $processed++;
        }

        $this->newLine();
        $this->info("Done. Created/updated: {$processed}, skipped: {$skipped}, failed: {$failed}.");

        return $failed > 0 ? self::FAILURE : self::SUCCESS;
    }

    private function pythonBinary(): string
    {
        return PHP_OS_FAMILY === 'Windows' ? 'python' : 'python3';
    }
}
