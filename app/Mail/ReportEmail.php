<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReportEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $create_case;
    public $attachmentPath;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($create_case, $attachmentPath)
    {
         $this->create_case = $create_case;
        $this->attachmentPath = $attachmentPath;
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
        $mail = $this->subject('5-Minute Interval Report.')->view('email.reports_template');

        if ($this->attachmentPath) {
            $mail->attach($this->attachmentPath);
        }

        return $mail;
    }
}
