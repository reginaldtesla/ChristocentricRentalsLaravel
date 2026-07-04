<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Support\ProductCatalog;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        foreach (ProductCatalog::all() as $item) {
            $category = Category::where('slug', $item['category_slug'])->first();

            Product::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'category_id' => $category?->id,
                    'name' => $item['name'],
                    'description' => $item['excerpt'],
                    'excerpt' => $item['excerpt'],
                    'price_per_day' => $item['price'],
                    'image' => $item['image'],
                    'is_new' => $item['is_new'],
                    'is_featured' => $item['is_featured'],
                    'rating' => $item['rating'],
                    'in_stock' => $item['in_stock'],
                ]
            );
        }
    }
}
