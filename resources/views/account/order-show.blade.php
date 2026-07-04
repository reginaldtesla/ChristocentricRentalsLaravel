@extends('layouts.app')

@section('title', 'Order ' . $order->order_number . ' — ' . config('app.name'))

@section('content')
    <x-pages.hero :title="'Order ' . $order->order_number" subtitle="Rental booking details." />

    <div class="container-site py-10">
        @include('account._nav')

        <div class="grid gap-8 lg:grid-cols-3">
            <div class="lg:col-span-2 space-y-4">
                @foreach ($order->items as $item)
                    <div class="rounded-2xl border border-gray-200 bg-white p-6">
                        <h3 class="font-semibold text-gray-900">{{ $item->product_name }}</h3>
                        <p class="mt-1 text-sm text-gray-500">{{ $item->formattedSchedule() }} ({{ $item->days }} days)</p>
                        <p class="mt-2 font-semibold text-primary">{{ \App\Services\RentalPricing::format((float) $item->line_total) }}</p>
                    </div>
                @endforeach
            </div>
            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-6">
                <h2 class="font-semibold text-gray-900">Summary</h2>
                <dl class="mt-4 space-y-2 text-sm">
                    <div class="flex justify-between"><dt class="text-gray-500">Status</dt><dd class="capitalize">{{ $order->status }}</dd></div>
                    <div class="flex justify-between"><dt class="text-gray-500">Payment method</dt><dd>{{ $order->paymentMethodLabel() }}</dd></div>
                    <div class="flex justify-between"><dt class="text-gray-500">Payment status</dt><dd class="capitalize">{{ $order->payment_status }}</dd></div>
                    <div class="flex justify-between"><dt class="text-gray-500">Total</dt><dd class="font-bold text-primary">{{ $order->formattedTotal() }}</dd></div>
                </dl>
                <a href="{{ route('account.orders') }}" class="mt-6 inline-block text-sm text-primary hover:underline">← Back to orders</a>
            </div>
        </div>
    </div>
@endsection
