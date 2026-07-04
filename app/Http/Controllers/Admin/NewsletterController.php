<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use App\Models\NewsletterSubscriber;
use App\Services\NewsletterBroadcaster;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function index()
    {
        return view('admin.newsletters.index', [
            'newsletters' => Newsletter::latest()->paginate(15),
            'subscriberCount' => NewsletterSubscriber::active()->count(),
        ]);
    }

    public function create()
    {
        return view('admin.newsletters.form', [
            'newsletter' => new Newsletter,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);
        $newsletter = Newsletter::create($validated);

        return redirect()
            ->route('admin.newsletters.edit', $newsletter)
            ->with('success', 'Newsletter draft saved. Review it, then send to subscribers.');
    }

    public function edit(Newsletter $newsletter)
    {
        return view('admin.newsletters.form', compact('newsletter'));
    }

    public function update(Request $request, Newsletter $newsletter)
    {
        if ($newsletter->isSent()) {
            return back()->with('error', 'Sent newsletters cannot be edited.');
        }

        $newsletter->update($this->validated($request));

        return back()->with('success', 'Newsletter draft updated.');
    }

    public function destroy(Newsletter $newsletter)
    {
        if ($newsletter->isSent()) {
            return back()->with('error', 'Sent newsletters cannot be deleted.');
        }

        $newsletter->delete();

        return redirect()
            ->route('admin.newsletters.index')
            ->with('success', 'Newsletter draft deleted.');
    }

    public function send(Newsletter $newsletter, NewsletterBroadcaster $broadcaster)
    {
        if ($newsletter->isSent()) {
            return back()->with('error', 'This newsletter has already been sent.');
        }

        $subscriberCount = NewsletterSubscriber::active()->count();

        if ($subscriberCount === 0) {
            return back()->with('error', 'There are no active subscribers to send to yet.');
        }

        try {
            $result = $broadcaster->send($newsletter);
        } catch (\Throwable $exception) {
            return back()->with('error', 'Could not send newsletter: '.$exception->getMessage());
        }

        $message = "Newsletter sent to {$result['sent']} subscriber(s).";

        if ($result['failed'] > 0) {
            $message .= " {$result['failed']} delivery attempt(s) failed — check the log.";
        }

        return redirect()
            ->route('admin.newsletters.index')
            ->with('success', $message);
    }

    /**
     * @return array<string, string>
     */
    private function validated(Request $request): array
    {
        return $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string', 'max:50000'],
        ]);
    }
}
