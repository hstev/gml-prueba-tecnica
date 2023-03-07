<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Mail\Mailer;

class SendRegistrationConfirmation implements ShouldQueue
{
    use InteractsWithQueue;
    
    protected $mailer;
    /**
     * Create the event listener.
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        $user = $event->user;

        $this->mailer->send('emails.registration_confirmation', ['user' => $user], function ($message) use ($user) {
            $message->to($user->email)->subject('Confirmación de registro');
        });
    }
}
