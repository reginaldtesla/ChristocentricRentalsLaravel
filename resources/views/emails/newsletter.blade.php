<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $newsletter->subject }}</title>
</head>
<body style="margin:0;padding:0;background:#f3f4f6;font-family:Arial,Helvetica,sans-serif;color:#111827;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f3f4f6;padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:600px;background:#ffffff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">
                    <tr>
                        <td style="padding:28px 32px 12px;background:#1e73be;color:#ffffff;">
                            <p style="margin:0;font-size:12px;letter-spacing:0.12em;text-transform:uppercase;opacity:0.9;">{{ config('app.name') }}</p>
                            <h1 style="margin:12px 0 0;font-size:24px;line-height:1.3;font-weight:700;">{{ $newsletter->subject }}</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:28px 32px;font-size:15px;line-height:1.7;color:#374151;">
                            {!! nl2br(e($newsletter->body)) !!}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 32px 28px;">
                            <a href="{{ route('shop') }}" style="display:inline-block;background:#1e73be;color:#ffffff;text-decoration:none;padding:12px 20px;border-radius:8px;font-size:14px;font-weight:600;">Browse gear</a>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:20px 32px;border-top:1px solid #e5e7eb;background:#f9fafb;font-size:12px;line-height:1.6;color:#6b7280;">
                            <p style="margin:0 0 8px;">You are receiving this because you subscribed to {{ config('app.name') }}.</p>
                            <p style="margin:0;">
                                <a href="{{ route('newsletter.unsubscribe', $subscriber->unsubscribe_token) }}" style="color:#1e73be;">Unsubscribe</a>
                                &nbsp;·&nbsp;
                                {{ config('site.contact.address') }}, {{ config('site.contact.city') }}
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
