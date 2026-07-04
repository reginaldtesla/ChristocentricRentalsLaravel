<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Support\ProductDescriptions;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ApplyProductDescriptions extends Command
{
    protected $signature = 'catalog:apply-descriptions {--dry-run : Preview without saving}';

    protected $description = 'Apply researched product descriptions (not from old site clone)';

    public function handle(): int
    {
        $descriptions = ProductDescriptions::all();
        $updated = 0;
        $missing = [];

        foreach (Product::orderBy('name')->get() as $product) {
            $entry = $descriptions[$product->slug] ?? null;

            if ($entry === null) {
                $missing[] = $product->slug;
                continue;
            }

            $description = trim($entry['description']);
            $excerpt = trim($entry['excerpt'] ?? Str::limit($description, 200));

            if ($this->option('dry-run')) {
                $this->line("{$product->slug}: ".Str::limit($description, 100));
                $updated++;

                continue;
            }

            $product->update([
                'description' => $description,
                'excerpt' => $excerpt,
            ]);
            $updated++;
        }

        $this->info("Updated {$updated} product descriptions.");

        if ($missing !== []) {
            $this->warn('Missing descriptions for '.count($missing).' products:');
            foreach ($missing as $slug) {
                $this->line("  - {$slug}");
            }
        }

        return $missing === [] ? self::SUCCESS : self::FAILURE;
    }
}
