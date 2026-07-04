<?php

namespace App\Models;

use App\Services\RentalPricing;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'price_per_day',
        'days',
        'quantity',
        'line_total',
        'rental_start',
        'rental_end',
        'pickup_time',
        'return_time',
        'returned_at',
        'late_penalty',
    ];

    protected function casts(): array
    {
        return [
            'price_per_day' => 'decimal:2',
            'line_total' => 'decimal:2',
            'late_penalty' => 'decimal:2',
            'rental_start' => 'date',
            'rental_end' => 'date',
            'returned_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function formattedSchedule(): string
    {
        return RentalPricing::formatScheduleRange(
            $this->rental_start->format('Y-m-d'),
            $this->pickup_time,
            $this->rental_end->format('Y-m-d'),
            $this->return_time,
        );
    }
}
