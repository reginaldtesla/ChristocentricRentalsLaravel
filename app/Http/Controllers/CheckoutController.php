<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use App\Services\OrderMailer;
use App\Services\PaystackService;
use App\Services\RentalAvailability;
use App\Services\RentopianSyncService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct(
        private CartService $cart,
        private PaystackService $paystack,
        private RentopianSyncService $rentopian,
        private RentalAvailability $availability,
        private OrderMailer $orderMailer,
    ) {}

    public function index()
    {
        if ($this->cart->count() === 0) {
            return redirect()->route('shop')->with('error', 'Your cart is empty.');
        }

        $unavailable = $this->availability->validateCartItems($this->cart->items());

        if ($unavailable !== []) {
            $names = collect($unavailable)->pluck('name')->implode(', ');

            return redirect()->route('cart.index')->with('error', "Some items are no longer available for your dates: {$names}. Please update your cart.");
        }

        $paystackAvailable = $this->paystack->isConfigured() || config('payments.demo_mode');
        $pickupCashEnabled = (bool) config('payments.pickup_cash.enabled', true);

        if (! $paystackAvailable && ! $pickupCashEnabled) {
            return redirect()->route('cart.index')->with('error', 'Checkout is temporarily unavailable. Please contact us to complete your booking.');
        }

        return view('checkout.index', [
            'items' => $this->cart->items(),
            'subtotal' => $this->cart->subtotal(),
            'user' => auth()->user(),
            'paystackAvailable' => $paystackAvailable,
            'pickupCashEnabled' => $pickupCashEnabled,
        ]);
    }

    public function store(Request $request)
    {
        if ($this->cart->count() === 0) {
            return redirect()->route('shop')->with('error', 'Your cart is empty.');
        }

        $unavailable = $this->availability->validateCartItems($this->cart->items());

        if ($unavailable !== []) {
            $message = collect($unavailable)->map(function (array $item) {
                return "{$item['name']} (only {$item['available']} available)";
            })->implode('; ');

            return back()->with('error', "Availability changed: {$message}. Please update your cart.");
        }

        $validated = $request->validate([
            'customer_phone' => ['required', 'string', 'max:30'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'payment_method' => ['required', 'in:paystack,pickup_cash'],
        ]);

        if ($validated['payment_method'] === 'pickup_cash' && ! config('payments.pickup_cash.enabled', true)) {
            return back()->with('error', 'Pay on pickup is not available right now. Please pay online.');
        }

        if ($validated['payment_method'] === 'paystack' && ! $this->paystack->isConfigured() && ! config('payments.demo_mode')) {
            return back()->with('error', 'Online payment is not available. Please choose pay on pickup or contact support.');
        }

        $user = $request->user();

        $order = DB::transaction(function () use ($validated, $user) {
            $items = $this->cart->items();
            $subtotal = $this->cart->subtotal();

            $user->update(['phone' => $validated['customer_phone']]);

            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => Order::generateOrderNumber(),
                'status' => 'pending',
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'customer_phone' => $validated['customer_phone'],
                'rental_start' => $this->cart->earliestStart(),
                'rental_end' => $this->cart->latestEnd(),
                'subtotal' => $subtotal,
                'total' => $subtotal,
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'unpaid',
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'],
                    'price_per_day' => $item['price_per_day'],
                    'days' => $item['days'],
                    'quantity' => $item['quantity'],
                    'line_total' => $item['line_total'],
                    'rental_start' => $item['rental_start'],
                    'rental_end' => $item['rental_end'],
                    'pickup_time' => $item['pickup_time'] ?? config('site.rental_defaults.pickup_time'),
                    'return_time' => $item['return_time'] ?? config('site.rental_defaults.return_time'),
                ]);
            }

            return $order;
        });

        session(['pending_order_id' => $order->id]);

        if ($order->isPickupCash()) {
            $this->completePickupCashOrder($order);

            return redirect()->route('checkout.pickup', $order);
        }

        if ($this->paystack->isConfigured()) {
            $payment = $this->paystack->initialize($order);

            if ($payment) {
                $order->update(['payment_reference' => $payment['reference']]);

                return redirect()->away($payment['authorization_url']);
            }
        }

        if (config('payments.demo_mode')) {
            return redirect()->route('checkout.demo-pay', $order);
        }

        return back()->with('error', 'Payment is not configured. Please contact support.');
    }

    public function callback(Request $request)
    {
        $reference = $request->query('reference');

        if (! $reference) {
            return redirect()->route('home')->with('error', 'Invalid payment reference.');
        }

        $order = Order::where('payment_reference', $reference)->firstOrFail();

        if ($this->paystack->verify($reference)) {
            $this->markOrderPaid($order, $reference);

            return redirect()->route('checkout.success', $order);
        }

        return redirect()->route('checkout.cancel', $order)->with('error', 'Payment verification failed.');
    }

    public function demoPay(Order $order)
    {
        $this->authorizeOrder($order);

        if (! config('payments.demo_mode')) {
            abort(404);
        }

        return view('checkout.demo-pay', compact('order'));
    }

    public function completeDemoPay(Order $order)
    {
        $this->authorizeOrder($order);

        if (! config('payments.demo_mode')) {
            abort(404);
        }

        $this->markOrderPaid($order, 'DEMO_'.time());

        return redirect()->route('checkout.success', $order);
    }

    public function pickup(Order $order)
    {
        $this->authorizeOrder($order);

        abort_unless($order->isPickupCash(), 404);

        return view('checkout.pickup', compact('order'));
    }

    public function success(Order $order)
    {
        $this->authorizeOrder($order);

        return view('checkout.success', compact('order'));
    }

    public function cancel(Order $order)
    {
        $this->authorizeOrder($order);

        return view('checkout.cancel', compact('order'));
    }

    private function authorizeOrder(Order $order): void
    {
        abort_unless($order->user_id === auth()->id(), 403);
    }

    private function completePickupCashOrder(Order $order): void
    {
        $this->cart->clear();
        session()->forget('pending_order_id');

        $order->load('items');
        $this->orderMailer->sendConfirmation($order);
    }

    private function markOrderPaid(Order $order, string $reference): void
    {
        if ($order->isPaid()) {
            return;
        }

        $order->update([
            'payment_status' => 'paid',
            'payment_reference' => $reference,
            'status' => 'confirmed',
        ]);

        $this->cart->clear();
        session()->forget('pending_order_id');

        $order->load('items');
        $this->rentopian->pushOrder($order);
        $this->orderMailer->sendConfirmation($order);
    }
}
