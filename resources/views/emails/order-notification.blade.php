<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>New order</title>
</head>
<body style="font-family:Arial,Helvetica,sans-serif;color:#111827;line-height:1.6;">
    <h1 style="font-size:20px;">New rental order: {{ $order->order_number }}</h1>
    <p><strong>Customer:</strong> {{ $order->customer_name }} ({{ $order->customer_email }})</p>
    <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
    <p><strong>Total:</strong> {{ $order->formattedTotal() }}</p>
    <p><strong>Payment:</strong> {{ $order->paymentMethodLabel() }} ({{ $order->payment_status }})</p>
    <ul>
        @foreach ($order->items as $item)
            <li>{{ $item->product_name }} — {{ $item->formattedSchedule() }} × {{ $item->quantity }}</li>
        @endforeach
    </ul>
    @if ($order->notes)
        <p><strong>Notes:</strong> {{ $order->notes }}</p>
    @endif
</body>
</html>
