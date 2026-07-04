<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;

class RentalDue
{
    public static function dueAt(OrderItem $item): Carbon
    {
        $date = $item->rental_end->format('Y-m-d');
        $time = self::normalizeTime($item->return_time ?? config('site.rental_defaults.return_time', '17:00'));

        return Carbon::parse("{$date} {$time}");
    }

    public static function pickupAt(OrderItem $item): Carbon
    {
        $date = $item->rental_start->format('Y-m-d');
        $time = self::normalizeTime($item->pickup_time ?? config('site.rental_defaults.pickup_time', '09:00'));

        return Carbon::parse("{$date} {$time}");
    }

    /**
     * @return array{
     *     state: string,
     *     due_at: string,
     *     seconds_remaining: int,
     *     label: string,
     *     late_penalty: float,
     *     late_days: int,
     *     is_returned: bool
     * }
     */
    public static function snapshot(OrderItem $item, ?Carbon $reference = null): array
    {
        $reference ??= now();
        $dueAt = self::dueAt($item);
        $returnedAt = $item->returned_at ? Carbon::parse($item->returned_at) : null;
        $isReturned = $returnedAt !== null;
        $compareAt = $returnedAt ?? $reference;
        $secondsRemaining = (int) ($dueAt->getTimestamp() - $compareAt->getTimestamp());
        $penalty = (float) ($item->late_penalty ?? 0);
        $lateDays = self::lateDays($item, $compareAt);

        if ($isReturned) {
            $state = $penalty > 0 ? 'returned_late' : 'returned';
            $label = $penalty > 0
                ? 'Returned late — penalty '.RentalPricing::format($penalty)
                : 'Returned on time';
        } elseif ($secondsRemaining < 0) {
            $state = 'overdue';
            $penalty = self::calculatePenalty($item, $reference);
            $label = 'Overdue by '.self::formatDuration(abs($secondsRemaining));
        } elseif ($secondsRemaining <= self::dueSoonSeconds()) {
            $state = 'due_soon';
            $label = 'Due in '.self::formatDuration($secondsRemaining);
        } else {
            $state = 'active';
            $label = 'Due in '.self::formatDuration($secondsRemaining);
        }

        return [
            'state' => $state,
            'due_at' => $dueAt->toIso8601String(),
            'seconds_remaining' => (int) $secondsRemaining,
            'label' => $label,
            'late_penalty' => round($penalty, 2),
            'late_days' => $lateDays,
            'is_returned' => $isReturned,
        ];
    }

    /**
     * @return array{state: string, label: string, seconds_remaining: int|null, late_penalty: float}
     */
    public static function orderSummary(Order $order): array
    {
        $items = $order->relationLoaded('items') ? $order->items : $order->items()->get();

        if ($items->isEmpty()) {
            return [
                'state' => 'none',
                'label' => '—',
                'seconds_remaining' => null,
                'late_penalty' => 0.0,
            ];
        }

        $snapshots = $items->map(fn (OrderItem $item) => self::snapshot($item));

        if ($snapshots->every(fn (array $snapshot) => $snapshot['is_returned'])) {
            $penalty = $snapshots->sum('late_penalty');

            return [
                'state' => $penalty > 0 ? 'returned_late' : 'returned',
                'label' => $penalty > 0 ? 'Returned · penalty due' : 'All returned',
                'seconds_remaining' => null,
                'late_penalty' => (float) $penalty,
            ];
        }

        $active = $snapshots->filter(fn (array $snapshot) => ! $snapshot['is_returned']);

        $worst = $active->sortBy('seconds_remaining')->first();

        return [
            'state' => $worst['state'],
            'label' => $worst['label'],
            'seconds_remaining' => $worst['seconds_remaining'],
            'late_penalty' => (float) $active->sum('late_penalty'),
        ];
    }

    public static function calculatePenalty(OrderItem $item, ?Carbon $returnedAt = null): float
    {
        $returnedAt ??= now();
        $dueAt = self::dueAt($item);
        $graceEnd = $dueAt->copy()->addMinutes(self::graceMinutes());

        if ($returnedAt <= $graceEnd) {
            return 0.0;
        }

        $minutesLate = $graceEnd->diffInMinutes($returnedAt);
        $lateDays = max(1, (int) ceil($minutesLate / 1440));

        return round(
            $lateDays * (float) $item->price_per_day * (int) $item->quantity * self::dailyMultiplier(),
            2,
        );
    }

    public static function lateDays(OrderItem $item, ?Carbon $returnedAt = null): int
    {
        $returnedAt ??= now();
        $graceEnd = self::dueAt($item)->copy()->addMinutes(self::graceMinutes());

        if ($returnedAt <= $graceEnd) {
            return 0;
        }

        $minutesLate = $graceEnd->diffInMinutes($returnedAt);

        return max(1, (int) ceil($minutesLate / 1440));
    }

    public static function formatDuration(int $seconds): string
    {
        $seconds = abs($seconds);

        if ($seconds < 60) {
            return "{$seconds}s";
        }

        if ($seconds < 3600) {
            return intdiv($seconds, 60).'m';
        }

        if ($seconds < 86400) {
            $hours = intdiv($seconds, 3600);
            $minutes = intdiv($seconds % 3600, 60);

            return $minutes > 0 ? "{$hours}h {$minutes}m" : "{$hours}h";
        }

        $days = intdiv($seconds, 86400);
        $hours = intdiv($seconds % 86400, 3600);

        return $hours > 0 ? "{$days}d {$hours}h" : "{$days}d";
    }

    public static function formatCountdown(int $secondsRemaining): string
    {
        if ($secondsRemaining >= 0) {
            return self::formatDuration($secondsRemaining).' left';
        }

        return self::formatDuration($secondsRemaining).' overdue';
    }

    public static function graceMinutes(): int
    {
        return (int) config('site.rental_penalties.grace_minutes', 30);
    }

    public static function dailyMultiplier(): float
    {
        return (float) config('site.rental_penalties.daily_rate_multiplier', 1);
    }

    public static function dueSoonHours(): int
    {
        return (int) config('site.rental_penalties.due_soon_hours', 24);
    }

    private static function dueSoonSeconds(): int
    {
        return self::dueSoonHours() * 3600;
    }

    private static function normalizeTime(mixed $time): string
    {
        if ($time instanceof \DateTimeInterface) {
            return $time->format('H:i');
        }

        return substr((string) $time, 0, 5);
    }
}
