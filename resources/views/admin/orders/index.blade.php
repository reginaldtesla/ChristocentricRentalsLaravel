@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
    <div class="mt-6 overflow-hidden rounded-xl border border-gray-200 bg-white">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-500">
                <tr>
                    <th class="px-4 py-3">Order</th>
                    <th class="px-4 py-3">Customer</th>
                    <th class="px-4 py-3">Dates</th>
                    <th class="px-4 py-3">Return countdown</th>
                    <th class="px-4 py-3">Total</th>
                    <th class="px-4 py-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    @php($summary = \App\Services\RentalDue::orderSummary($order))
                    <tr class="border-t border-gray-100">
                        <td class="px-4 py-3"><a href="{{ route('admin.orders.show', $order) }}" class="font-medium text-primary hover:underline">{{ $order->order_number }}</a></td>
                        <td class="px-4 py-3">{{ $order->customer_name }}<br><span class="text-gray-500">{{ $order->customer_email }}</span></td>
                        <td class="px-4 py-3">{{ $order->rental_start?->format('M j') }} – {{ $order->rental_end?->format('M j, Y') }}</td>
                        <td class="px-4 py-3">
                            @if ($order->isPaid() && $order->status !== 'cancelled' && $summary['state'] !== 'none')
                                <span @class([
                                    'inline-flex rounded-full px-2.5 py-1 text-xs font-medium',
                                    'bg-red-100 text-red-800' => in_array($summary['state'], ['overdue', 'returned_late']),
                                    'bg-amber-100 text-amber-900' => $summary['state'] === 'due_soon',
                                    'bg-green-100 text-green-800' => in_array($summary['state'], ['returned']),
                                    'bg-blue-100 text-blue-800' => $summary['state'] === 'active',
                                ])>
                                    {{ $summary['label'] }}
                                </span>
                                @if ($summary['late_penalty'] > 0)
                                    <p class="mt-1 text-xs text-red-700">Penalty {{ config('site.currency_symbol') }}{{ number_format($summary['late_penalty'], 2) }}</p>
                                @endif
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $order->formattedTotal() }}</td>
                        <td class="px-4 py-3 capitalize">{{ $order->status }} / {{ $order->payment_status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $orders->links() }}</div>
@endsection
