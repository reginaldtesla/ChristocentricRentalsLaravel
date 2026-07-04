<?php

namespace App\Models;

use App\Support\ProductImage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'excerpt',
        'price_per_day',
        'image',
        'is_new',
        'is_featured',
        'rating',
        'in_stock',
        'quantity',
        'rentopian_id',
    ];

    protected function casts(): array
    {
        return [
            'price_per_day' => 'decimal:2',
            'is_new' => 'boolean',
            'is_featured' => 'boolean',
            'in_stock' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function formattedPrice(): string
    {
        return config('site.currency_symbol').number_format((float) $this->price_per_day, 2);
    }

    public function imageSourcePath(): string
    {
        return ProductImage::pathForSlug($this->slug, $this->image);
    }

    public function imageUrl(string $size = ProductImage::SIZE_CARD): string
    {
        return ProductImage::url($this->imageSourcePath(), $size);
    }

    public function galleryImageUrl(): string
    {
        return $this->imageUrl(ProductImage::SIZE_LARGE);
    }

    /**
     * @return list<array{path: string, width: int}>
     */
    public function imageSrcset(): array
    {
        return ProductImage::srcset($this->imageSourcePath());
    }

    public function resolvedImagePath(string $size = ProductImage::SIZE_CARD): string
    {
        return ProductImage::resolveStoragePath($this->imageSourcePath(), $size);
    }

    /**
     * @return array<string, mixed>
     */
    public function toCardArray(): array
    {
        return [
            'slug' => $this->slug,
            'name' => $this->name,
            'price' => (float) $this->price_per_day,
            'image' => $this->imageSourcePath(),
            'category' => $this->category?->name,
            'category_slug' => $this->category?->slug,
            'excerpt' => $this->excerpt,
            'is_new' => $this->is_new,
            'is_featured' => $this->is_featured,
            'rating' => $this->rating,
            'in_stock' => $this->in_stock,
        ];
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeNewest(Builder $query): Builder
    {
        return $query->where('is_new', true);
    }

    public function scopeInStock(Builder $query): Builder
    {
        return $query->where('in_stock', true);
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if ($term === null || trim($term) === '') {
            return $query;
        }

        $needle = '%'.strtolower(trim($term)).'%';

        return $query->where(function (Builder $q) use ($needle) {
            $q->whereRaw('LOWER(name) LIKE ?', [$needle])
                ->orWhereHas('category', fn (Builder $c) => $c->whereRaw('LOWER(name) LIKE ?', [$needle]));
        });
    }

    public function scopeForCategorySlug(Builder $query, ?string $slug): Builder
    {
        if ($slug === null || $slug === '') {
            return $query;
        }

        $categoryMap = [
            'cameras' => ['canon-cameras', 'sony-cameras', 'cameras'],
            'lens' => ['lens', 'canon-lenses', 'sony-lenses', 'sigma-lenses'],
        ];

        $slugs = $categoryMap[$slug] ?? [$slug];

        return $query->whereHas('category', fn (Builder $q) => $q->whereIn('slug', $slugs));
    }
}
