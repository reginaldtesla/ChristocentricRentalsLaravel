@props(['snapshot', 'itemId' => null])

@php
    $state = $snapshot['state'];
    $stateClass = match ($state) {
        'overdue' => 'is-overdue',
        'returned_late' => 'is-returned-late',
        'due_soon' => 'is-due-soon',
        'returned' => 'is-returned',
        default => 'is-active',
    };
@endphp

<div
    class="admin-rental-countdown {{ $stateClass }}"
    @if (! $snapshot['is_returned'])
        data-rental-countdown
        data-due-at="{{ $snapshot['due_at'] }}"
        data-due-soon-hours="{{ config('site.rental_penalties.due_soon_hours', 24) }}"
        data-state="{{ $state }}"
    @endif
>
    <div class="admin-rental-countdown-head">
        <span class="admin-rental-countdown-badge">{{ ucfirst(str_replace('_', ' ', $state)) }}</span>
        @if ($snapshot['is_returned'] && $itemId)
            <span class="text-xs text-gray-500">Item #{{ $itemId }}</span>
        @endif
    </div>

    @if ($snapshot['is_returned'])
        <p class="admin-rental-countdown-label">{{ $snapshot['label'] }}</p>
    @else
        <p class="admin-rental-countdown-timer" data-countdown-display>
            {{ \App\Services\RentalDue::formatCountdown($snapshot['seconds_remaining']) }}
        </p>
        <p class="admin-rental-countdown-due text-xs text-gray-500">
            Return by {{ \Carbon\Carbon::parse($snapshot['due_at'])->format('M j, Y g:i A') }}
        </p>
    @endif

    @if ($snapshot['late_penalty'] > 0)
        <p class="admin-rental-countdown-penalty">
            Late penalty: {{ config('site.currency_symbol') }}{{ number_format($snapshot['late_penalty'], 2) }}
            @if ($snapshot['late_days'] > 0)
                <span class="text-gray-500">({{ $snapshot['late_days'] }} late day{{ $snapshot['late_days'] === 1 ? '' : 's' }})</span>
            @endif
        </p>
    @endif
</div>
