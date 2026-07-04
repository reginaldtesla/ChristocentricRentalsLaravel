@extends('layouts.app')

@section('title', 'Order Confirmed — ' . config('app.name'))

@section('content')
    <div class="container-site py-20 text-center">
        <div class="mx-auto max-w-lg rounded-2xl border border-green-200 bg-green-50 p-10">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-green-600 text-white">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900">Booking Confirmed!</h1>
            <p class="mt-3 text-gray-600">Thank you, {{ $order->customer_name }}. Your rental order has been received.</p>
            <p class="mt-4 text-sm text-gray-500">Order number: <strong>{{ $order->order_number }}</strong></p>
            <p class="mt-1 text-lg font-bold text-primary">{{ $order->formattedTotal() }}</p>

            <a href="{{ route('account.orders.show', $order->order_number) }}" class="btn-solid mt-8 inline-flex">View Order</a>
        </div>
    </div>
@endsection
