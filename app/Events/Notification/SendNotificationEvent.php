<?php

namespace App\Events\Notification;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendNotificationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $requsetNotification;

    public function __construct($requsetNotification)
    {
        $this->requsetNotification = $requsetNotification;
    }
}
