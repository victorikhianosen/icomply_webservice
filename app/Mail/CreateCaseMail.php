<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CreateCaseMail extends Mailable
{
    use Queueable, SerializesModels;
    public $create_case;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($create_case)
    {
        return $this->create_case = $create_case;
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
        return $this->subject('')->view('email.create_case_mail');
    }
}
