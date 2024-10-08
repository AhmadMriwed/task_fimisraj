<?php

namespace App\Providers;

use App\Events\Notification\SendNotificationEvent;
use App\Events\Notification\SendUserNotificationEvent;
use App\Events\UserEmailVerificationEvent;
use App\Listeners\Notification\SendNotificationListener;
use App\Listeners\Notification\SendUserNotificationListener;
use App\Listeners\UserEmailVerificationListener;

use Illuminate\Auth\Events\Registered;
// use App\Models\User;
// use App\Observers\UserObserver;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    
       
    UserEmailVerificationEvent::class => [
        UserEmailVerificationListener::class
    ],
    SendUserNotificationEvent::class => [
        SendUserNotificationListener::class
    ],
    SendNotificationEvent::class => [
        SendNotificationListener::class
    ],
    
    'SocialiteProviders\Manager\SocialiteWasCalled' => [
        'SocialiteProviders\Graph\GraphExtendSocialite@handle'
    ],
    ];

    // protected $observers = [
    //     User::class => [
    //         UserObserver::class
    //     ]
    // ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
