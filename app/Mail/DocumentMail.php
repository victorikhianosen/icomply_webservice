<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DocumentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $document_notification;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($document_notification)
    {
        return $this->document_notification = $document_notification;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function build()
    {
        return $this->subject('Document Notification ')->view('email.document_email');
    }
}
