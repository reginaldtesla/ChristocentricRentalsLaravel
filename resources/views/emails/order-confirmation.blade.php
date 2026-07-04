<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order confirmed</title>
</head>
<body style="margin:0;padding:0;background:#f3f4f6;font-family:Arial,Helvetica,sans-serif;color:#111827;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f3f4f6;padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:600px;background:#ffffff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">
                    <tr>
                        <td style="padding:28px 32px 12px;background:#1e73be;color:#ffffff;">
                            <p style="margin:0;font-size:12px;letter-spacing:0.12em;text-transform:uppercase;opacity:0.9;">{{ config('app.name') }}</p>
                            <h1 style="margin:12px 0 0;font-size:24px;line-height:1.3;font-weight:700;">Thanks for your booking!</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:28px 32px;font-size:15px;line-height:1.7;color:#374151;">
                            <p style="margin:0 0 16px;">Hi {{ $order->customer_name }},</p>
                            @if ($order->isPickupCash() && ! $order->isPaid())
                                <p style="margin:0 0 16px;">Your rental order <strong>{{ $order->order_number }}</strong> is reserved. Please visit our office to pay <strong>{{ $order->formattedTotal() }}</strong> in cash when you pick up your gear.</p>
                                <p style="margin:0 0 16px;">Bring valid Ghana Card and this order number. Payment is required before equipment is released.</p>
                            @else
                                <p style="margin:0 0 16px;">Your rental order <strong>{{ $order->order_number }}</strong> is confirmed. Here is a summary:</p>
                            @endif

                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="margin:20px 0;border-collapse:collapse;font-size:14px;">
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td style="padding:10px 0;border-bottom:1px solid #e5e7eb;">
                                            <strong>{{ $item->product_name }}</strong><br>
                                            {{ $item->formattedSchedule() }}
                                            · {{ $item->days }} day(s) · Qty {{ $item->quantity }}
                                        </td>
                                        <td style="padding:10px 0;border-bottom:1px solid #e5e7eb;text-align:right;white-space:nowrap;">
                                            {{ config('site.currency_symbol') }}{{ number_format((float) $item->line_total, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td style="padding:14px 0;font-weight:700;">Total</td>
                                    <td style="padding:14px 0;text-align:right;font-weight:700;">{{ $order->formattedTotal() }}</td>
                                </tr>
                            </table>

                            <p style="margin:0 0 8px;"><strong>Pickup location</strong></p>
                            <p style="margin:0 0 16px;">{{ config('site.contact.address') }}, {{ config('site.contact.city') }}</p>

                            <p style="margin:0 0 8px;"><strong>Questions?</strong></p>
                            <p style="margin:0;">Email <a href="mailto:{{ config('site.contact.support_email') }}" style="color:#1e73be;">{{ config('site.contact.support_email') }}</a> or call {{ config('site.contact.phone_display') }}.</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 32px 28px;">
                            <a href="{{ route('account.orders.show', $order->order_number) }}" style="display:inline-block;background:#1e73be;color:#ffffff;text-decoration:none;padding:12px 20px;border-radius:8px;font-size:14px;font-weight:600;">View order</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
