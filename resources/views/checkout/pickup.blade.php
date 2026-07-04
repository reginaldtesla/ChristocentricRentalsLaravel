@extends('layouts.app')

@section('title', 'Pickup Booking — ' . config('app.name'))

@section('content')
    <div class="container-site py-20">
        <div class="mx-auto max-w-2xl rounded-2xl border border-amber-200 bg-amber-50 p-10">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-amber-500 text-white">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>

            <h1 class="text-center text-2xl font-bold text-gray-900">Booking reserved — pay at pickup</h1>
            <p class="mt-3 text-center text-gray-600">
                Thanks, {{ $order->customer_name }}. Your order is saved. Visit our office to pay in cash and collect your gear.
            </p>

            <div class="mt-6 rounded-xl border border-amber-200 bg-white p-5 text-sm text-gray-700">
                <p class="font-semibold text-gray-900">Order number</p>
                <p class="mt-1 text-lg font-bold text-primary">{{ $order->order_number }}</p>
                <p class="mt-4 font-semibold text-gray-900">Amount due at pickup</p>
                <p class="mt-1 text-2xl font-bold text-gray-900">{{ $order->formattedTotal() }}</p>
            </div>

            <div class="mt-6 space-y-4 text-sm text-gray-700">
                <div>
                    <p class="font-semibold text-gray-900">What to bring</p>
                    <ul class="mt-2 list-disc space-y-1 pl-5">
                        <li>Valid Ghana Card (required for first-time clients)</li>
                        <li>Cash payment for the full rental total</li>
                        <li>This order number: <strong>{{ $order->order_number }}</strong></li>
                    </ul>
                </div>

                <div>
                    <p class="font-semibold text-gray-900">Office location</p>
                    <p class="mt-1">{{ config('site.contact.address') }}, {{ config('site.contact.city') }}</p>
                    <p class="mt-1">Phone: <a href="tel:{{ preg_replace('/\D+/', '', config('site.contact.phone')) }}" class="text-primary hover:underline">{{ config('site.contact.phone_display') }}</a></p>
                </div>

                <p class="rounded-lg bg-white p-4 text-xs text-gray-600">
                    Your gear is held for {{ config('payments.pickup_cash.hold_hours', 72) }} hours while awaiting payment. If you cannot make it in time, please call us so we can help reschedule.
                </p>
            </div>

            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <a href="{{ route('account.orders.show', $order->order_number) }}" class="btn-solid inline-flex">View order</a>
                <a href="{{ route('contact') }}" class="btn-outline inline-flex">Contact us</a>
            </div>
        </div>
    </div>
@endsection
