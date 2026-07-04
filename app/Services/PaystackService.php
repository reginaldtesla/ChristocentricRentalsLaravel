<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaystackService
{
    public function isConfigured(): bool
    {
        return filled(config('payments.paystack.secret_key'));
    }

    /**
     * @return array{authorization_url: string, reference: string}|null
     */
    public function initialize(Order $order): ?array
    {
        if (! $this->isConfigured()) {
            return null;
        }

        $reference = 'CR_'.$order->id.'_'.time();

        $response = Http::withToken(config('payments.paystack.secret_key'))
            ->post('https://api.paystack.co/transaction/initialize', [
                'email' => $order->customer_email,
                'amount' => (int) round($order->total * 100),
                'reference' => $reference,
                'currency' => config('payments.paystack.currency', 'GHS'),
                'callback_url' => route('checkout.callback'),
                'metadata' => [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                ],
            ]);

        if (! $response->successful() || ! $response->json('status')) {
            Log::error('Paystack init failed', ['body' => $response->json()]);

            return null;
        }

        return [
            'authorization_url' => $response->json('data.authorization_url'),
            'reference' => $reference,
        ];
    }

    public function verify(string $reference): bool
    {
        if (! $this->isConfigured()) {
            return false;
        }

        $response = Http::withToken(config('payments.paystack.secret_key'))
            ->get('https://api.paystack.co/transaction/verify/'.$reference);

        return $response->successful()
            && $response->json('status')
            && $response->json('data.status') === 'success';
    }
}
