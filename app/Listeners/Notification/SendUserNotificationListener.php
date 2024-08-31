<?php


namespace App\Listeners\Notification;

use App\Models\Fcm;
use App\Models\Notification\Notification;
use App\Models\User;
use App\Models\UserIds;
use  App\Events\Notification\SendUserNotificationEvent;
use Illuminate\Support\Facades\Log;


class SendUserNotificationListener
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
    public function handle(SendUserNotificationEvent $event): void
    {
        $user = User::query()->find($event->user_id);
        $fcms=$user->fcms;

        foreach ($fcms as $fcm){
            if ($fcm != null) {
                $url = env('NOTIFICATION_URL');
                $FcmToken = $fcm;
                $serverKey = env('NOTIFICATION_SERVER_KEY');
                $data = [
                    "to" => $FcmToken,
                    "notification" => [
                        "title" => $event->title,
                        "body" => $event->body,
                        "sound" => 'default'
                    ]
                ];
                $encodedData = json_encode($data);
                $headers = [
                    'Authorization:key=' . $serverKey,
                    'Content-Type: application/json',
                ];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
                $response = curl_exec($ch);
                curl_close($ch);
                Log::info($response);
            }
    
            Notification::query()->create([
                'user_id' => $event->user_id,
                'title' => $event->title,
                'body' => $event->body
            ]);
        }
       
    }
}
