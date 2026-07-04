@extends('layouts.app')

@section('title', 'Payment Cancelled — ' . config('app.name'))

@section('content')
    <div class="container-site py-20 text-center">
        <h1 class="text-2xl font-bold text-gray-900">Payment Not Completed</h1>
        <p class="mt-3 text-gray-600">Your order {{ $order->order_number }} was not paid. You can try again from your cart.</p>
        <a href="{{ route('cart.index') }}" class="btn-solid mt-8 inline-flex">Back to Cart</a>
    </div>
@endsection
