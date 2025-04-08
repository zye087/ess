<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountActivatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $parent;
    public $portalLink;

    public function __construct($parent, $portalLink)
    {
        $this->parent = $parent;
        $this->portalLink = $portalLink;
    }

    public function build()
    {
        return $this->subject('Your Account is Now Active')
                    ->view('emails.parent-account-activated')
                    ->with([
                        'parent' => $this->parent,
                        'portalLink' => $this->portalLink
                    ]);
    }
}

