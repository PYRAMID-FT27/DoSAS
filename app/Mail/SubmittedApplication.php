<?php

namespace App\Mail;

use App\Models\DefermentApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubmittedApplication extends Mailable
{
    use Queueable, SerializesModels;

    public DefermentApplication $da;
    public string $buttonRoute;

    /**
     * Create a new message instance.
     */
    public function __construct(DefermentApplication $da)
    {
        $this->da = $da;
        $this->buttonRoute = route('defermentApplication.show', $da->id);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Submitted Application',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.application.submitted',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
