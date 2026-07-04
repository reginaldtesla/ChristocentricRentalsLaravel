<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use App\Services\RentalAvailability;
use App\Services\RentalPricing;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        private CartService $cart,
        private RentalAvailability $availability,
    ) {}

    public function index()
    {
        return view('cart.index', [
            'items' => $this->cart->items(),
            'subtotal' => $this->cart->subtotal(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'rental_start' => ['required', 'date', 'after_or_equal:today'],
            'rental_end' => ['required', 'date', 'after_or_equal:rental_start'],
            'pickup_time' => ['required', 'date_format:H:i'],
            'return_time' => ['required', 'date_format:H:i'],
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if (! $product->in_stock) {
            return back()->with('error', 'This product is currently out of stock.');
        }

        $start = $validated['rental_start'];
        $end = $validated['rental_end'];
        $requested = $validated['quantity'] ?? 1;
        $inCart = $this->cart->quantityFor($product->id, $start, $end);
        $maxAllowed = $this->maxAllowedQuantity($product, $start, $end, $inCart);

        if ($maxAllowed < 1) {
            return back()->with('error', 'This item is not available for the selected dates.');
        }

        if ($requested > $maxAllowed) {
            return back()->with('error', "Only {$maxAllowed} unit(s) available for these dates.");
        }

        $this->cart->add(
            $product,
            $start,
            $end,
            $requested,
            $validated['pickup_time'],
            $validated['return_time'],
        );

        return redirect()->route('cart.index')->with('success', 'Added to cart.');
    }

    public function update(Request $request, string $key)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
            'rental_start' => ['nullable', 'date'],
            'rental_end' => ['nullable', 'date', 'after_or_equal:rental_start'],
            'pickup_time' => ['nullable', 'date_format:H:i'],
            'return_time' => ['nullable', 'date_format:H:i'],
        ]);

        $item = $this->cart->findItem($key);

        if ($item === null) {
            return back()->with('error', 'Cart item not found.');
        }

        $product = Product::find($item['product_id']);

        if ($product === null || ! $product->in_stock) {
            return back()->with('error', 'This product is no longer available.');
        }

        $start = $validated['rental_start'] ?? $item['rental_start'];
        $end = $validated['rental_end'] ?? $item['rental_end'];
        $maxAllowed = $this->maxTotalQuantity($product, $start, $end, $item['quantity']);

        if ($maxAllowed < 1) {
            return back()->with('error', 'This item is not available for the selected dates.');
        }

        if ($validated['quantity'] > $maxAllowed) {
            return back()->with('error', "Only {$maxAllowed} unit(s) available for these dates.");
        }

        $this->cart->update(
            $key,
            $validated['quantity'],
            $validated['rental_start'] ?? null,
            $validated['rental_end'] ?? null,
            $validated['pickup_time'] ?? null,
            $validated['return_time'] ?? null,
        );

        return back()->with('success', 'Cart updated.');
    }

    public function destroy(string $key)
    {
        $this->cart->remove($key);

        return back()->with('success', 'Item removed from cart.');
    }

    public function quote(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['nullable', 'exists:products,id'],
            'price_per_day' => ['required', 'numeric'],
            'rental_start' => ['required', 'date'],
            'rental_end' => ['required', 'date', 'after_or_equal:rental_start'],
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $days = RentalPricing::rentalDays($validated['rental_start'], $validated['rental_end']);
        $quantity = $validated['quantity'] ?? 1;
        $total = RentalPricing::lineTotal(
            (float) $validated['price_per_day'],
            $days,
            $quantity,
        );

        $response = [
            'days' => $days,
            'total' => $total,
            'formatted' => RentalPricing::format($total),
        ];

        if ($validated['product_id'] ?? null) {
            $product = Product::find($validated['product_id']);

            if ($product) {
                $available = $this->availability->availableQuantity(
                    $product,
                    $validated['rental_start'],
                    $validated['rental_end'],
                );
                $stockCap = max(1, (int) ($product->quantity ?: 1));
                $response['available'] = $available;
                $response['max_quantity'] = $available > 0 ? min($available, $stockCap) : 0;
            }
        }

        return response()->json($response);
    }

    private function maxAllowedQuantity(Product $product, string $start, string $end, int $alreadyInCart): int
    {
        return $this->maxTotalQuantity($product, $start, $end, 0) - $alreadyInCart;
    }

    private function maxTotalQuantity(Product $product, string $start, string $end, int $currentLineQuantity = 0): int
    {
        $stockCap = max(1, (int) ($product->quantity ?: 1));
        $cartQty = $this->cart->quantityFor($product->id, $start, $end);
        $available = $this->availability->availableQuantity($product, $start, $end);

        return max(0, min($stockCap, $available - $cartQty + $currentLineQuantity));
    }
}
