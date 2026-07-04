<?php

namespace App\Services;

use Carbon\Carbon;

class RentalPricing
{
    public static function rentalDays(string $start, string $end): int
    {
        $startDate = Carbon::parse($start)->startOfDay();
        $endDate = Carbon::parse($end)->startOfDay();

        if ($endDate->lt($startDate)) {
            return 0;
        }

        return max(1, $startDate->diffInDays($endDate) + 1);
    }

    public static function lineTotal(float $pricePerDay, int $days, int $quantity = 1): float
    {
        return round($pricePerDay * $days * $quantity, 2);
    }

    public static function format(float $amount): string
    {
        return config('site.currency_symbol').number_format($amount, 2);
    }

    public static function formatTime(mixed $time): ?string
    {
        if ($time === null || $time === '') {
            return null;
        }

        if ($time instanceof \DateTimeInterface) {
            return Carbon::instance($time)->format('g:i A');
        }

        if (is_string($time) && trim($time) === '') {
            return null;
        }

        return Carbon::parse($time)->format('g:i A');
    }

    public static function formatSchedule(string $date, ?string $time): string
    {
        $line = Carbon::parse($date)->format('M j, Y');
        $formattedTime = self::formatTime($time);

        return $formattedTime ? "{$line} at {$formattedTime}" : $line;
    }

    public static function formatScheduleRange(string $startDate, ?string $startTime, string $endDate, ?string $endTime): string
    {
        return self::formatSchedule($startDate, $startTime).' → '.self::formatSchedule($endDate, $endTime);
    }
}
