<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ImportProductDescriptions extends Command
{
    protected $signature = 'catalog:import-descriptions {--dry-run : Preview without saving}';

    protected $description = 'Import product descriptions from the WordPress static clone';

    /**
     * DB slug => clone folder slug when they differ.
     *
     * @var array<string, string>
     */
    private array $slugAliases = [
        'canon-r5-body-only' => 'cannon-r5-body-only',
        'canon-5d-mark-iii' => 'experience-the-power-of-the-canon-5d-mark-iii',
        'canon-70-200mm-f-2-8-iii' => 'canon-70-200mm-f-2-8-iii-lens',
    ];

    public function handle(): int
    {
        $clonePath = config('site.clone_path');

        if (! is_dir($clonePath)) {
            $this->error("Clone path not found: {$clonePath}");

            return self::FAILURE;
        }

        $products = Product::orderBy('name')->get();
        $updated = 0;
        $skipped = 0;
        $missing = [];

        foreach ($products as $product) {
            $cloneSlug = $this->slugAliases[$product->slug] ?? $product->slug;
            $file = $clonePath.'/product/'.$cloneSlug.'/index.html';

            if (! is_file($file)) {
                $missing[] = $product->slug;
                continue;
            }

            $html = file_get_contents($file);
            $description = $this->extractDescription($html);

            if ($description === '') {
                $missing[] = $product->slug;
                continue;
            }

            $excerpt = Str::limit(strip_tags($description), 200);

            if ($this->option('dry-run')) {
                $this->line("{$product->slug}: ".Str::limit($description, 120));
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
            $this->warn('No description found for '.count($missing).' products:');
            foreach ($missing as $slug) {
                $this->line("  - {$slug}");
            }
        }

        return self::SUCCESS;
    }

    private function extractDescription(string $html): string
    {
        if (preg_match('/class="woocommerce-product-details__short-description"[^>]*>(.*?)<\/div>/s', $html, $match)) {
            $short = trim($this->htmlToText($match[1]));
            if ($short !== '') {
                return $short;
            }
        }

        if (preg_match('/id="tab-description"[^>]*>(.*?)<\/div>\s*<\/div>/s', $html, $match)) {
            $long = trim($this->htmlToText($match[1]));
            if ($long !== '') {
                return $long;
            }
        }

        if (preg_match('/class="woocommerce-Tabs-panel[^"]*panel-description[^"]*"[^>]*>(.*?)<\/div>/s', $html, $match)) {
            $panel = trim($this->htmlToText($match[1]));
            if ($panel !== '') {
                return $panel;
            }
        }

        if (preg_match('/woocommerce-Tabs-panel[^>]*>(.*?)<div id="reviews"/s', $html, $match)) {
            $fallback = trim($this->htmlToText($match[1]));
            if ($fallback !== '' && ! str_starts_with(strtolower($fallback), 'reviews')) {
                return $fallback;
            }
        }

        return '';
    }

    private function htmlToText(string $html): string
    {
        $html = preg_replace('/<\/h[1-6]>/i', "\n\n", $html) ?? $html;
        $html = preg_replace('/<br\s*\/?>/i', "\n", $html) ?? $html;
        $html = preg_replace('/<\/p>/i', "\n\n", $html) ?? $html;
        $html = preg_replace('/<\/li>/i', "\n", $html) ?? $html;
        $text = html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5);
        $text = preg_replace("/[ \t]+/", ' ', $text) ?? $text;
        $text = preg_replace("/\n{3,}/", "\n\n", $text) ?? $text;

        return trim($text);
    }
}
