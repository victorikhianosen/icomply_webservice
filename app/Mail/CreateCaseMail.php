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
        $mail = $this->subject('New Case Creation')->view('email.create_case_mail');
        if (!empty($this->attachmentPath) && file_exists($this->attachmentPath)) {
            // $mail->attach($this->attachmentPath);
            $extension = pathinfo($this->attachmentPath, PATHINFO_EXTENSION);
            $customName = 'case_creation_file.' . $extension;
            $mail->attach($this->attachmentPath, ['as' => $customName]);
              }
            
        return $mail;
    }
}
