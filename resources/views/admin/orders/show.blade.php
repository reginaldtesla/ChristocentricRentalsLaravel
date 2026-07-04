@extends('layouts.admin')

@section('title', 'Order ' . $order->order_number)

@section('content')
    @php
        $totalPenalty = $order->items->sum('late_penalty');
        $orderSummary = \App\Services\RentalDue::orderSummary($order);
    @endphp

    @if ($order->isPaid() && $order->status !== 'cancelled')
        <div class="mb-6 rounded-xl border border-gray-200 bg-white p-4">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="text-sm font-medium text-gray-900">Order return status</p>
                    <p class="text-sm text-gray-500">{{ $orderSummary['label'] }}</p>
                </div>
                @if ($totalPenalty > 0)
                    <p class="text-lg font-bold text-red-700">
                        Total penalties: {{ config('site.currency_symbol') }}{{ number_format($totalPenalty, 2) }}
                    </p>
                @endif
            </div>
        </div>
    @endif

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="space-y-4 lg:col-span-2">
            @foreach ($order->items as $item)
                @php($snapshot = $itemSnapshots[$item->id] ?? \App\Services\RentalDue::snapshot($item))
                <div class="rounded-xl border border-gray-200 bg-white p-4">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                        <div>
                            <p class="font-semibold">{{ $item->product_name }}</p>
                            <p class="text-sm text-gray-500">{{ $item->formattedSchedule() }} · {{ $item->days }} days · Qty {{ $item->quantity }}</p>
                            <p class="mt-1 font-semibold text-primary">{{ \App\Services\RentalPricing::format((float) $item->line_total) }}</p>
                        </div>

                        @if ($order->isPaid() && $order->status !== 'cancelled')
                            <div class="w-full lg:max-w-xs">
                                <x-admin-rental-countdown :snapshot="$snapshot" :item-id="$item->id" />

                                @unless ($item->returned_at)
                                    <form action="{{ route('admin.orders.items.return', [$order, $item]) }}" method="POST" class="mt-3" onsubmit="return confirm('Mark this item as returned now?');">
                                        @csrf
                                        <button type="submit" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-800 hover:bg-gray-50">
                                            Mark returned
                                        </button>
                                    </form>
                                @else
                                    <p class="mt-3 text-xs text-gray-500">Returned {{ $item->returned_at->format('M j, Y g:i A') }}</p>
                                @endunless
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6">
            <dl class="space-y-2 text-sm">
                <div><dt class="text-gray-500">Customer</dt><dd class="font-medium">{{ $order->customer_name }}</dd></div>
                <div><dt class="text-gray-500">Email</dt><dd>{{ $order->customer_email }}</dd></div>
                <div><dt class="text-gray-500">Phone</dt><dd>{{ $order->customer_phone ?? '—' }}</dd></div>
                <div><dt class="text-gray-500">Payment method</dt><dd>{{ $order->paymentMethodLabel() }}</dd></div>
                <div><dt class="text-gray-500">Payment status</dt><dd class="capitalize">{{ $order->payment_status }}</dd></div>
                <div><dt class="text-gray-500">Rental total</dt><dd class="text-lg font-bold text-primary">{{ $order->formattedTotal() }}</dd></div>
                @if ($totalPenalty > 0)
                    <div><dt class="text-gray-500">Late penalties</dt><dd class="font-bold text-red-700">{{ config('site.currency_symbol') }}{{ number_format($totalPenalty, 2) }}</dd></div>
                @endif
            </dl>

            <div class="mt-4 rounded-lg border border-blue-100 bg-blue-50 p-3 text-xs text-blue-900">
                <p class="font-medium">Late return policy</p>
                <p class="mt-1">{{ config('site.rental_penalties.grace_minutes', 30) }} min grace after return time, then {{ config('site.rental_penalties.daily_rate_multiplier', 1) }}× daily rate per late day.</p>
                <a href="{{ route('admin.settings.rental') }}" class="mt-2 inline-block font-medium text-primary hover:underline">Edit penalty rules</a>
            </div>

            @if ($order->isPickupCash() && ! $order->isPaid())
                <div class="mt-4 rounded-lg border border-amber-200 bg-amber-50 p-3 text-xs text-amber-950">
                    <p class="font-medium">Pay on pickup</p>
                    <p class="mt-1">Customer chose cash payment at the office. Mark payment as <strong>paid</strong> and order as <strong>confirmed</strong> when they pay and collect gear.</p>
                </div>
            @endif

            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="mt-6 space-y-3 border-t border-gray-100 pt-6">
                @csrf @method('PATCH')
                <div>
                    <label class="mb-1 block text-sm font-medium">Order status</label>
                    <select name="status" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                        @foreach (['pending', 'confirmed', 'cancelled', 'completed'] as $status)
                            <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium">Payment status</label>
                    <select name="payment_status" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                        @foreach (['unpaid', 'paid', 'refunded'] as $status)
                            <option value="{{ $status }}" @selected($order->payment_status === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn-solid w-full">Update Order</button>
            </form>
        </div>
    </div>
@endsection
