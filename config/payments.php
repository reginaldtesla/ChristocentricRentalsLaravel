<?php

return [

    'paystack' => [
        'public_key' => env('PAYSTACK_PUBLIC_KEY'),
        'secret_key' => env('PAYSTACK_SECRET_KEY'),
        'currency' => env('PAYSTACK_CURRENCY', 'GHS'),
    ],

    'demo_mode' => env('PAYMENT_DEMO_MODE', true),

    'pickup_cash' => [
        'enabled' => env('PAYMENT_PICKUP_CASH_ENABLED', true),
        // How long unpaid pickup orders reserve stock before expiring.
        'hold_hours' => (int) env('PAYMENT_PICKUP_CASH_HOLD_HOURS', 72),
    ],

];
