<?php

namespace App\Listeners\Notification;
use App\Events\Notification\SendNotificationEvent;
use App\Events\Notification\SendUserNotificationEvent;

class SendNotificationListener
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
    public function handle(SendNotificationEvent $event): void
    {
        event(new SendUserNotificationEvent($event->requsetNotification->user_id,
        $event->requsetNotification->title,$event->requsetNotification->body));
    }
}
