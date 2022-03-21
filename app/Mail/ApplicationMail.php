<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $application, $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($application, $user)
    {
        $this->application = $application;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Nowy wniosek")->view('mails.applicationNotification');
    }
}
