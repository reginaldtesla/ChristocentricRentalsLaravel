@extends('layouts.app')

@section('title', 'Complete Payment — ' . config('app.name'))

@section('content')
    <div class="container-site py-20 text-center">
        <h1 class="text-2xl font-bold text-gray-900">Demo Payment</h1>
        <p class="mt-3 text-gray-600">Paystack is not configured. Use demo mode to complete this order.</p>
        <p class="mt-6 text-3xl font-bold text-primary">{{ $order->formattedTotal() }}</p>
        <p class="mt-2 text-sm text-gray-500">Order {{ $order->order_number }}</p>

        <form action="{{ route('checkout.demo-pay.complete', $order) }}" method="POST" class="mt-8">
            @csrf
            <button type="submit" class="btn-solid px-10 py-3">Complete Demo Payment</button>
        </form>
    </div>
@endsection
