<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ExceptionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $process_notification;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($process_notification)
    {
        return $this->process_notification = $process_notification;
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
        return $this->subject('Exception Process Notification ')->view('email.process_email');
    }
}
