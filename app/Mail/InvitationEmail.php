<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $invitationLink;

    /**
     * Create a new message instance.
     *
     * @param  string  $invitationLink
     * @return void
     */
    public function __construct($invitationLink)
    {
        $this->invitationLink = $invitationLink;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Invitation Email')
                    ->view('emails.invitation_email');
    }
}
