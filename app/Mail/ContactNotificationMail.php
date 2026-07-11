<?php

namespace App\Mail;

use App\Models\ContactSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactSubmission $submission)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New contact request from '.$this->submission->name,
            replyTo: [$this->submission->email],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-notification',
            with: [
                'submission' => $this->submission,
                'logoPath' => public_path('onix/assets/images/proxwebs-mail-logo.png'),
                'siteName' => 'Proxwebs',
                'siteUrl' => config('app.url'),
            ],
        );
    }
}
