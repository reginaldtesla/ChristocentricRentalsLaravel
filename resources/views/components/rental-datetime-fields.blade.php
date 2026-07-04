@props([
    'pickupDate' => null,
    'returnDate' => null,
    'pickupTime' => '09:00',
    'returnTime' => '17:00',
])

<div class="space-y-5">
    <div class="rental-datetime-group">
        <p class="rental-datetime-label">Pickup date</p>
        <div class="rental-datetime-row">
            <div class="rental-datetime-field">
                <span class="rental-datetime-icon" aria-hidden="true">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </span>
                <input
                    type="date"
                    id="rental_start"
                    name="rental_start"
                    value="{{ old('rental_start', $pickupDate ?? now()->addDay()->format('Y-m-d')) }}"
                    min="{{ now()->format('Y-m-d') }}"
                    required
                    class="rental-datetime-input"
                    data-rental-start
                >
            </div>
            <div class="rental-datetime-field">
                <span class="rental-datetime-icon" aria-hidden="true">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
                <input
                    type="time"
                    id="pickup_time"
                    name="pickup_time"
                    value="{{ old('pickup_time', $pickupTime) }}"
                    required
                    class="rental-datetime-input"
                    data-rental-pickup-time
                >
            </div>
        </div>
    </div>

    <div class="rental-datetime-group">
        <p class="rental-datetime-label">Return date</p>
        <div class="rental-datetime-row">
            <div class="rental-datetime-field">
                <span class="rental-datetime-icon" aria-hidden="true">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </span>
                <input
                    type="date"
                    id="rental_end"
                    name="rental_end"
                    value="{{ old('rental_end', $returnDate ?? now()->addDays(2)->format('Y-m-d')) }}"
                    min="{{ now()->format('Y-m-d') }}"
                    required
                    class="rental-datetime-input"
                    data-rental-end
                >
            </div>
            <div class="rental-datetime-field">
                <span class="rental-datetime-icon" aria-hidden="true">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
                <input
                    type="time"
                    id="return_time"
                    name="return_time"
                    value="{{ old('return_time', $returnTime) }}"
                    required
                    class="rental-datetime-input"
                    data-rental-return-time
                >
            </div>
        </div>
    </div>
</div>
