<?php

namespace App\Mail\Admin;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailRoom extends Mailable 
//implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $mailer_subject, $mailer_massage, $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailer_subject, $mailer_massage, User $user)
    {
        $this->mailer_subject = $mailer_subject;
        $this->mailer_massage = $mailer_massage;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.admin.mailroom', [[$this->mailer_massage]])
            ->subject($this->mailer_subject);
    }
}
