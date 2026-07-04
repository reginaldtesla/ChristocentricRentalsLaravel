@extends('layouts.admin')

@section('title', 'Payments')

@section('content')
    <p class="text-sm text-gray-600">Payment keys are stored in <code class="rounded bg-gray-100 px-1">.env</code> for security. This page shows the current status.</p>

    <div class="mt-6 max-w-2xl space-y-4">
        <div class="rounded-xl border border-gray-200 bg-white p-6">
            <dl class="space-y-4 text-sm">
                <div class="flex justify-between gap-4">
                    <dt class="text-gray-600">Demo mode</dt>
                    <dd class="font-medium {{ $demoMode ? 'text-amber-600' : 'text-green-700' }}">{{ $demoMode ? 'On (test checkouts)' : 'Off (live payments)' }}</dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="text-gray-600">Currency</dt>
                    <dd class="font-medium text-gray-900">{{ $currency }}</dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="text-gray-600">Paystack keys</dt>
                    <dd class="font-medium {{ $paystackConfigured ? 'text-green-700' : 'text-red-600' }}">{{ $paystackConfigured ? 'Configured' : 'Not configured' }}</dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="text-gray-600">Pay on pickup (cash)</dt>
                    <dd class="font-medium {{ $pickupCashEnabled ? 'text-green-700' : 'text-gray-600' }}">{{ $pickupCashEnabled ? 'Enabled' : 'Disabled' }}</dd>
                </div>
            </dl>
        </div>

        <div class="rounded-xl border border-blue-100 bg-blue-50 p-5 text-sm text-blue-900">
            <p class="font-medium">To change payment settings, update your <code class="rounded bg-white/70 px-1">.env</code> file:</p>
            <pre class="mt-3 overflow-x-auto rounded bg-white p-3 text-xs text-gray-800">PAYSTACK_PUBLIC_KEY=...
PAYSTACK_SECRET_KEY=...
PAYSTACK_CURRENCY=GHS
PAYMENT_DEMO_MODE=true
PAYMENT_PICKUP_CASH_ENABLED=true
PAYMENT_PICKUP_CASH_HOLD_HOURS=72</pre>
        </div>
    </div>
@endsection
