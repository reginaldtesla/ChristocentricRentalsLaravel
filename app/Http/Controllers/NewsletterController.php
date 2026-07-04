<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        NewsletterSubscriber::subscribeEmail($validated['email']);

        return back()->with('newsletter_success', 'You\'re on the list — thanks for subscribing!');
    }
}
