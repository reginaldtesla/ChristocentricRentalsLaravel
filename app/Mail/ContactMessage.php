<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMessage extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  array{name: string, email: string, message: string}  $data
     */
    public function __construct(public array $data) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Contact form — '.config('app.name'),
            replyTo: [$this->data['email']],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact',
        );
    }
}
