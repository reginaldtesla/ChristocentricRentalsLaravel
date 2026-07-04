<?php

namespace App\Services;

use App\Mail\NewsletterIssue;
use App\Models\Newsletter;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NewsletterBroadcaster
{
    /**
     * @return array{sent: int, failed: int}
     */
    public function send(Newsletter $newsletter): array
    {
        if ($newsletter->isSent()) {
            throw new \RuntimeException('This newsletter has already been sent.');
        }

        $sent = 0;
        $failed = 0;

        NewsletterSubscriber::active()
            ->orderBy('id')
            ->chunkById(50, function ($subscribers) use ($newsletter, &$sent, &$failed) {
                foreach ($subscribers as $subscriber) {
                    try {
                        Mail::to($subscriber->email)->send(new NewsletterIssue($newsletter, $subscriber));
                        $sent++;
                    } catch (\Throwable $exception) {
                        $failed++;
                        Log::error('Newsletter delivery failed', [
                            'newsletter_id' => $newsletter->id,
                            'subscriber_id' => $subscriber->id,
                            'email' => $subscriber->email,
                            'message' => $exception->getMessage(),
                        ]);
                    }
                }
            });

        $newsletter->update([
            'status' => Newsletter::STATUS_SENT,
            'sent_at' => now(),
            'recipient_count' => $sent,
        ]);

        return compact('sent', 'failed');
    }
}
