<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CloseCaseMail extends Mailable
{
    use Queueable, SerializesModels;
    public $close_case;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($close_case)
    {
        return $this->close_case = $close_case;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function build()
    {
        return $this->subject('')->view('email.close_case_mail');
    }
}
