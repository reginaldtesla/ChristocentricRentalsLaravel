<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'customer_name',
        'customer_email',
        'customer_phone',
        'rental_start',
        'rental_end',
        'subtotal',
        'total',
        'payment_method',
        'payment_reference',
        'payment_status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'rental_start' => 'date',
            'rental_end' => 'date',
            'subtotal' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateOrderNumber(): string
    {
        return 'CR-'.strtoupper(Str::random(8));
    }

    public function formattedTotal(): string
    {
        return config('site.currency_symbol').number_format((float) $this->total, 2);
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function isPickupCash(): bool
    {
        return $this->payment_method === 'pickup_cash';
    }

    public function paymentMethodLabel(): string
    {
        return match ($this->payment_method) {
            'pickup_cash' => 'Pay on pickup (cash)',
            'paystack' => 'Pay online (Paystack)',
            default => ucfirst(str_replace('_', ' ', (string) $this->payment_method)),
        };
    }
}
