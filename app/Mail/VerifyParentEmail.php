<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyParentEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $parent;
    public $verificationLink;

    public function __construct($parent, $verificationLink)
    {
        $this->parent = $parent;
        $this->verificationLink = $verificationLink;
    }

    public function build()
    {
        return $this->subject('Verify Your Email')
            ->view('emails.parent-verify');
    }
}
