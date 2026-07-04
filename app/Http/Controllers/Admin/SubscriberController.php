<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SubscriberController extends Controller
{
    public function index()
    {
        return view('admin.subscribers.index', [
            'subscribers' => NewsletterSubscriber::query()
                ->orderByDesc('subscribed_at')
                ->paginate(30),
            'activeCount' => NewsletterSubscriber::active()->count(),
        ]);
    }

    public function destroy(NewsletterSubscriber $subscriber)
    {
        $subscriber->unsubscribe();

        return back()->with('success', 'Subscriber removed.');
    }

    public function export(): StreamedResponse
    {
        $filename = 'newsletter-subscribers-'.now()->format('Y-m-d').'.csv';

        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['email', 'status', 'subscribed_at', 'unsubscribed_at']);

            NewsletterSubscriber::query()
                ->orderBy('email')
                ->chunk(200, function ($subscribers) use ($handle) {
                    foreach ($subscribers as $subscriber) {
                        fputcsv($handle, [
                            $subscriber->email,
                            $subscriber->isActive() ? 'active' : 'unsubscribed',
                            $subscriber->subscribed_at?->toDateTimeString(),
                            $subscriber->unsubscribed_at?->toDateTimeString(),
                        ]);
                    }
                });

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
