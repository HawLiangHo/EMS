<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AssistantNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    private User $assistant;
    private string $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($assistant, $password)
    {
        $this->assistant = $assistant;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Welcome to EMS as Event Assistant')
                    ->markdown('email.assistantNotification', ['assistant' => $this->assistant, 'password' => $this->password]);
    }
}
