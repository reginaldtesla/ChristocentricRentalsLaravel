<?php

namespace App\Services;

use App\Models\Product;
use App\Support\ProductImage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class CartService
{
    private const SESSION_KEY = 'rental_cart';

    /**
     * @return list<array<string, mixed>>
     */
    public function items(): array
    {
        return Session::get(self::SESSION_KEY, []);
    }

    public function count(): int
    {
        return array_sum(array_column($this->items(), 'quantity'));
    }

    public function subtotal(): float
    {
        return array_sum(array_column($this->items(), 'line_total'));
    }

    public function add(
        Product $product,
        string $rentalStart,
        string $rentalEnd,
        int $quantity = 1,
        ?string $pickupTime = null,
        ?string $returnTime = null,
    ): void {
        $days = RentalPricing::rentalDays($rentalStart, $rentalEnd);
        $lineTotal = RentalPricing::lineTotal((float) $product->price_per_day, $days, $quantity);
        $key = $this->itemKey($product->id, $rentalStart, $rentalEnd);
        $pickupTime = $pickupTime ?: config('site.rental_defaults.pickup_time', '09:00');
        $returnTime = $returnTime ?: config('site.rental_defaults.return_time', '17:00');

        $items = $this->items();
        $items[$key] = [
            'key' => $key,
            'product_id' => $product->id,
            'slug' => $product->slug,
            'name' => $product->name,
            'image' => $product->imageSourcePath(),
            'price_per_day' => (float) $product->price_per_day,
            'rental_start' => $rentalStart,
            'rental_end' => $rentalEnd,
            'pickup_time' => $pickupTime,
            'return_time' => $returnTime,
            'days' => $days,
            'quantity' => $quantity,
            'line_total' => $lineTotal,
        ];

        Session::put(self::SESSION_KEY, $items);
    }

    public function update(
        string $key,
        int $quantity,
        ?string $rentalStart = null,
        ?string $rentalEnd = null,
        ?string $pickupTime = null,
        ?string $returnTime = null,
    ): void {
        $items = $this->items();

        if (! isset($items[$key])) {
            return;
        }

        $item = $items[$key];
        $start = $rentalStart ?? $item['rental_start'];
        $end = $rentalEnd ?? $item['rental_end'];
        $days = RentalPricing::rentalDays($start, $end);

        $items[$key]['quantity'] = max(1, $quantity);
        $items[$key]['rental_start'] = $start;
        $items[$key]['rental_end'] = $end;
        if ($pickupTime !== null) {
            $items[$key]['pickup_time'] = $pickupTime;
        }
        if ($returnTime !== null) {
            $items[$key]['return_time'] = $returnTime;
        }
        $items[$key]['days'] = $days;
        $items[$key]['line_total'] = RentalPricing::lineTotal($item['price_per_day'], $days, $items[$key]['quantity']);

        Session::put(self::SESSION_KEY, $items);
    }

    public function remove(string $key): void
    {
        $items = $this->items();
        unset($items[$key]);
        Session::put(self::SESSION_KEY, $items);
    }

    public function clear(): void
    {
        Session::forget(self::SESSION_KEY);
    }

    public function earliestStart(): ?Carbon
    {
        $items = $this->items();

        if ($items === []) {
            return null;
        }

        return Carbon::parse(min(array_column($items, 'rental_start')));
    }

    public function latestEnd(): ?Carbon
    {
        $items = $this->items();

        if ($items === []) {
            return null;
        }

        return Carbon::parse(max(array_column($items, 'rental_end')));
    }

    public function quantityFor(int $productId, string $start, string $end): int
    {
        $key = $this->itemKey($productId, $start, $end);
        $items = $this->items();

        return (int) ($items[$key]['quantity'] ?? 0);
    }

    public function findItem(string $key): ?array
    {
        $items = $this->items();

        return $items[$key] ?? null;
    }

    private function itemKey(int $productId, string $start, string $end): string
    {
        return $productId.'_'.$start.'_'.$end;
    }
}
