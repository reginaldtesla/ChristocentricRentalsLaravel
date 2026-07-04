<?php

namespace App\Services;

use App\Mail\OrderConfirmation;
use App\Mail\OrderNotification;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderMailer
{
    public function sendConfirmation(Order $order): void
    {
        $order->loadMissing('items');

        try {
            Mail::to($order->customer_email)->send(new OrderConfirmation($order));
        } catch (\Throwable $exception) {
            Log::error('Order confirmation email failed', [
                'order_id' => $order->id,
                'email' => $order->customer_email,
                'message' => $exception->getMessage(),
            ]);
        }

        $staffEmail = config('site.contact.support_email');

        if ($staffEmail) {
            try {
                Mail::to($staffEmail)->send(new OrderNotification($order));
            } catch (\Throwable $exception) {
                Log::error('Order staff notification failed', [
                    'order_id' => $order->id,
                    'email' => $staffEmail,
                    'message' => $exception->getMessage(),
                ]);
            }
        }
    }
}
