@extends('layouts.app')

@section('title', 'Checkout — ' . config('app.name'))

@section('content')
    <x-pages.hero title="Checkout" subtitle="Complete your rental booking." />

    <div class="container-site py-10">
        <div class="grid gap-8 lg:grid-cols-3">
            <form action="{{ route('checkout.store') }}" method="POST" class="space-y-6 rounded-2xl border border-gray-200 bg-white p-6 lg:col-span-2">
                @csrf
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Confirm your details</h2>
                    <p class="mt-1 text-sm text-gray-500">Booking as <strong>{{ $user->name }}</strong> ({{ $user->email }})</p>
                </div>

                <div>
                    <label for="customer_phone" class="mb-1 block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" id="customer_phone" name="customer_phone" value="{{ old('customer_phone', $user->phone) }}" required class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm">
                </div>
                <div>
                    <label for="notes" class="mb-1 block text-sm font-medium text-gray-700">Notes (optional)</label>
                    <textarea id="notes" name="notes" rows="3" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm">{{ old('notes') }}</textarea>
                </div>

                <fieldset>
                    <legend class="mb-3 text-sm font-semibold text-gray-900">Payment method</legend>
                    <div class="space-y-3">
                        @if ($paystackAvailable)
                            <label class="checkout-payment-option">
                                <input type="radio" name="payment_method" value="paystack" @checked(old('payment_method', 'paystack') === 'paystack') required>
                                <span class="checkout-payment-option-body">
                                    <span class="checkout-payment-option-title">Pay online (Paystack)</span>
                                    <span class="checkout-payment-option-desc">Pay now by card or mobile money. Your booking is confirmed immediately after payment.</span>
                                </span>
                            </label>
                        @endif

                        @if ($pickupCashEnabled)
                            <label class="checkout-payment-option">
                                <input type="radio" name="payment_method" value="pickup_cash" @checked(old('payment_method') === 'pickup_cash' || (! $paystackAvailable && $pickupCashEnabled)) required>
                                <span class="checkout-payment-option-body">
                                    <span class="checkout-payment-option-title">Pay on pickup (cash)</span>
                                    <span class="checkout-payment-option-desc">Reserve now and pay in cash at our office when you collect the gear. Bring valid Ghana Card.</span>
                                </span>
                            </label>
                        @endif
                    </div>
                </fieldset>

                <div class="rounded-lg bg-primary-light p-4 text-sm text-gray-700">
                    <p class="font-semibold">Pickup policy</p>
                    <p class="mt-1">First-time clients must pick up in person with valid Ghana Card at {{ config('site.contact.address') }}, {{ config('site.contact.city') }}.</p>
                </div>

                <button type="submit" class="btn-solid w-full py-3">
                    @if ($paystackAvailable && $pickupCashEnabled)
                        Place order
                    @elseif ($pickupCashEnabled)
                        Reserve &amp; pay at pickup
                    @else
                        Place order &amp; pay
                    @endif
                </button>
            </form>

            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-6">
                <h2 class="text-lg font-semibold text-gray-900">Your Rental</h2>
                <ul class="mt-4 space-y-3">
                    @foreach ($items as $item)
                        <li class="text-sm">
                            <p class="font-medium text-gray-900">{{ $item['name'] }}</p>
                            <p class="text-gray-500">{{ \App\Services\RentalPricing::formatScheduleRange($item['rental_start'], $item['pickup_time'] ?? null, $item['rental_end'], $item['return_time'] ?? null) }} ({{ $item['days'] }} days)</p>
                            <p class="font-semibold text-primary">{{ \App\Services\RentalPricing::format($item['line_total']) }}</p>
                        </li>
                    @endforeach
                </ul>
                <div class="mt-6 flex justify-between border-t border-gray-200 pt-4 text-lg font-bold">
                    <span>Total</span>
                    <span>{{ \App\Services\RentalPricing::format($subtotal) }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
