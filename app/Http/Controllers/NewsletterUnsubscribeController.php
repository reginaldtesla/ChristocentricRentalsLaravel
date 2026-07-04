<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterUnsubscribeController extends Controller
{
    public function __invoke(Request $request, string $token)
    {
        $subscriber = NewsletterSubscriber::where('unsubscribe_token', $token)->first();

        if ($subscriber && $subscriber->isActive()) {
            $subscriber->unsubscribe();
        }

        return view('pages.newsletter-unsubscribed');
    }
}
