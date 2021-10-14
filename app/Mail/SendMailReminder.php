<?php

namespace App\Mail;

use App\Models\Events;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailReminder extends Mailable
{
    use Queueable, SerializesModels;

    private Events $event;
    private User $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Events $event, User $user)
    {
        $this->event = $event;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Reminder for Upcoming Event: ' . $this->event->title . '')
                    ->markdown('email.sendEmail', ['event' => $this->event, 'user' => $this->user]);
    }
}
