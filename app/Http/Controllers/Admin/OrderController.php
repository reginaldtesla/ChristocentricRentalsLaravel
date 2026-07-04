<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\RentalDue;
use App\Services\RentopianSyncService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(private RentopianSyncService $rentopian) {}

    public function index(Request $request)
    {
        $orders = Order::query()
            ->with('items')
            ->when($request->status, fn ($q, $status) => $q->where('status', $status))
            ->latest()
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items', 'user');

        $itemSnapshots = $order->items->mapWithKeys(fn (OrderItem $item) => [
            $item->id => RentalDue::snapshot($item),
        ]);

        return view('admin.orders.show', compact('order', 'itemSnapshots'));
    }

    public function markItemReturned(Order $order, OrderItem $item)
    {
        abort_unless($item->order_id === $order->id, 404);

        if ($item->returned_at) {
            return back()->with('error', 'This item has already been marked as returned.');
        }

        $returnedAt = now();
        $penalty = RentalDue::calculatePenalty($item, $returnedAt);

        $item->update([
            'returned_at' => $returnedAt,
            'late_penalty' => $penalty,
        ]);

        $message = $penalty > 0
            ? 'Item marked returned. Late penalty: '.config('site.currency_symbol').number_format($penalty, 2)
            : 'Item marked returned on time.';

        return back()->with('success', $message);
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,confirmed,cancelled,completed'],
            'payment_status' => ['required', 'in:unpaid,paid,refunded'],
        ]);

        $wasPaid = $order->isPaid();

        $order->update($validated);

        if (! $wasPaid && $validated['payment_status'] === 'paid') {
            if ($validated['status'] === 'pending') {
                $order->update(['status' => 'confirmed']);
            }

            $order->load('items');
            $this->rentopian->pushOrder($order);
        }

        return back()->with('success', 'Order updated.');
    }
}
