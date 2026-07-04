<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CompareService
{
    private const SESSION_KEY = 'compare_products';

    private const MAX_ITEMS = 4;

    /**
     * @return list<string>
     */
    public function slugs(): array
    {
        return array_values(Session::get(self::SESSION_KEY, []));
    }

    public function count(): int
    {
        return count($this->slugs());
    }

    public function maxItems(): int
    {
        return self::MAX_ITEMS;
    }

    public function has(string $slug): bool
    {
        return in_array($slug, $this->slugs(), true);
    }

    public function add(Product $product): bool
    {
        $slugs = $this->slugs();

        if (in_array($product->slug, $slugs, true)) {
            return true;
        }

        if (count($slugs) >= self::MAX_ITEMS) {
            return false;
        }

        $slugs[] = $product->slug;
        Session::put(self::SESSION_KEY, $slugs);

        return true;
    }

    public function remove(string $slug): void
    {
        $slugs = array_values(array_filter(
            $this->slugs(),
            fn (string $item) => $item !== $slug,
        ));

        Session::put(self::SESSION_KEY, $slugs);
    }

    public function clear(): void
    {
        Session::forget(self::SESSION_KEY);
    }

    /**
     * @return \Illuminate\Support\Collection<int, Product>
     */
    public function products()
    {
        $slugs = $this->slugs();

        if ($slugs === []) {
            return collect();
        }

        $products = Product::query()
            ->with('category')
            ->whereIn('slug', $slugs)
            ->get()
            ->keyBy('slug');

        return collect($slugs)
            ->map(fn (string $slug) => $products->get($slug))
            ->filter();
    }
}
