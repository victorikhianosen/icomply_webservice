<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UpdateCaseMail extends Mailable
{
    use Queueable, SerializesModels;
    public $update_case;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($update_case)
    {
        return $this->update_case = $update_case;
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
        return $this->subject('Case Response')->view('email.respond_to_case_mail');
    }
}
