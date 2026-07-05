<?php

namespace App\Support;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;

class SiteConfig
{
    public static function boot(): void
    {
        try {
            if (! Schema::hasTable('site_settings')) {
                return;
            }
        } catch (\Throwable) {
            return;
        }

        foreach (SiteSetting::query()->get() as $setting) {
            config(["site.{$setting->key}" => $setting->value]);
        }
    }

    public static function save(string $key, mixed $value): void
    {
        SiteSetting::query()->updateOrCreate(
            ['key' => $key],
            ['value' => $value],
        );

        config(["site.{$key}" => $value]);
    }

    /**
     * @return array<int, array{name: string, slug: string}>
     */
    public static function categoriesForNav(): array
    {
        try {
            $hasCategoriesTable = class_exists(\App\Models\Category::class) && Schema::hasTable('categories');
        } catch (\Throwable) {
            $hasCategoriesTable = false;
        }

        if ($hasCategoriesTable) {
            $fromDb = \App\Models\Category::query()
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get()
                ->map(fn ($category) => [
                    'name' => $category->name,
                    'slug' => $category->slug,
                ])
                ->all();

            if ($fromDb !== []) {
                return $fromDb;
            }
        }

        return config('site.categories', []);
    }
}
