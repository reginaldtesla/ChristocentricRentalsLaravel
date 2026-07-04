<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach (config('site.categories') as $index => $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                [
                    'name' => $category['name'],
                    'sort_order' => $index,
                ]
            );
        }
    }
}
