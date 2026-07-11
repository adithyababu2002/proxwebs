<?php

namespace App\Mail;

use App\Models\NewsletterSubscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public NewsletterSubscriber $subscriber)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New newsletter subscriber: '.$this->subscriber->email,
            replyTo: [$this->subscriber->email],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.newsletter-notification',
            with: [
                'subscriber' => $this->subscriber,
                'logoPath' => public_path('onix/assets/images/proxwebs-mail-logo.png'),
                'siteName' => 'Proxwebs',
                'siteUrl' => config('app.url'),
            ],
        );
    }
}
