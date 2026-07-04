<?php

namespace App\Services;

use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;

class RentalAvailability
{
    /**
     * @return list<array{product_id: int, name: string, requested: int, available: int}>
     */
    public function validateCartItems(array $items, ?int $excludeOrderId = null): array
    {
        $errors = [];

        foreach ($items as $item) {
            $product = Product::find($item['product_id']);

            if (! $product) {
                continue;
            }

            $requested = (int) $item['quantity'];
            $available = $this->availableQuantity(
                $product,
                $item['rental_start'],
                $item['rental_end'],
                $excludeOrderId,
            );

            if ($requested > $available) {
                $errors[] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'requested' => $requested,
                    'available' => $available,
                ];
            }
        }

        return $errors;
    }

    public function availableQuantity(
        Product $product,
        string $start,
        string $end,
        ?int $excludeOrderId = null,
    ): int {
        if (! $product->in_stock) {
            return 0;
        }

        $stock = max(1, (int) ($product->quantity ?: 1));
        $booked = $this->bookedQuantity($product->id, $start, $end, $excludeOrderId);

        return max(0, $stock - $booked);
    }

    public function bookedQuantity(
        int $productId,
        string $start,
        string $end,
        ?int $excludeOrderId = null,
    ): int {
        $startDate = Carbon::parse($start)->toDateString();
        $endDate = Carbon::parse($end)->toDateString();

        return (int) OrderItem::query()
            ->where('product_id', $productId)
            ->where('rental_start', '<=', $endDate)
            ->where('rental_end', '>=', $startDate)
            ->whereHas('order', function ($query) use ($excludeOrderId) {
                $holdHours = (int) config('payments.pickup_cash.hold_hours', 72);

                $query->where('status', '!=', 'cancelled')
                    ->where(function ($query) use ($holdHours) {
                        $query->where('payment_status', 'paid')
                            ->orWhere(function ($query) use ($holdHours) {
                                $query->where('payment_status', 'unpaid')
                                    ->where('status', 'pending')
                                    ->where('payment_method', 'pickup_cash')
                                    ->where('created_at', '>=', now()->subHours($holdHours));
                            })
                            ->orWhere(function ($query) {
                                $query->where('payment_status', 'unpaid')
                                    ->where('status', 'pending')
                                    ->where(function ($query) {
                                        $query->where('payment_method', '!=', 'pickup_cash')
                                            ->orWhereNull('payment_method');
                                    })
                                    ->where('created_at', '>=', now()->subHours(2));
                            });
                    });

                if ($excludeOrderId !== null) {
                    $query->where('id', '!=', $excludeOrderId);
                }
            })
            ->sum('quantity');
    }

    public function maxAddableQuantity(
        Product $product,
        string $start,
        string $end,
        int $alreadyInCart = 0,
    ): int {
        return max(0, $this->availableQuantity($product, $start, $end) - $alreadyInCart);
    }
}
