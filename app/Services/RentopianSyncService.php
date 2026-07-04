<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RentopianSyncService
{
    public function isConfigured(): bool
    {
        return filled(config('rentopian.api_key'));
    }

    public function pushOrder(Order $order): void
    {
        if (! $this->isConfigured()) {
            Log::info('Rentopian sync skipped — API key not configured', [
                'order_number' => $order->order_number,
            ]);

            return;
        }

        $payload = [
            'website_url' => config('rentopian.website_url'),
            'order_number' => $order->order_number,
            'customer' => [
                'name' => $order->customer_name,
                'email' => $order->customer_email,
                'phone' => $order->customer_phone,
            ],
            'rental_start' => $order->rental_start?->toDateString(),
            'rental_end' => $order->rental_end?->toDateString(),
            'total' => $order->total,
            'items' => $order->items->map(fn ($item) => [
                'product_id' => $item->product_id,
                'name' => $item->product_name,
                'days' => $item->days,
                'quantity' => $item->quantity,
                'line_total' => $item->line_total,
            ])->values()->all(),
        ];

        try {
            $response = Http::withToken(config('rentopian.api_key'))
                ->post(rtrim(config('rentopian.base_url'), '/').'/orders', $payload);

            if (! $response->successful()) {
                Log::warning('Rentopian sync failed', [
                    'order_number' => $order->order_number,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('Rentopian sync error', [
                'order_number' => $order->order_number,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
