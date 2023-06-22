<?php

namespace App\Listeners;

use App\Events\AppointmentCreated;
use App\Models\User;
use App\Notifications\NewAppointment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendAppointmentCreatedNotifications implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AppointmentCreated $event): void
    {
        print($event->appointment->user_id);
        foreach (User::whereNot('id', $event->appointment->user_id)->cursor() as $user) {
            $user->notify(new NewAppointment($event->appointment));
        }
    }
}
