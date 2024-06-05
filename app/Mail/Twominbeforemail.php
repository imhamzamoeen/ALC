<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Twominbeforemail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $users;
    protected $details;
    public function __construct($users, $class)
    {
        //
        $this->users = $users;
        $this->details = $class;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.partials.twominbefore.mail')->with([
            'user' => $this->users,
            'details' => $this->details,
        ])->subject('AlQuran Class Join Remainder');
    }
}
