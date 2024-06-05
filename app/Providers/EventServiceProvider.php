<?php

namespace App\Providers;

use App\Events\ClearStudentClassesEvent;
use App\Listeners\ClearStudentClassesListener;
use App\Listeners\NotifyStudentParentFromSalesSupportAction;
use App\Models\Course;
use App\Models\RescheduleRequest;
use App\Observers\CourseObserver;
use App\Observers\RescheduleObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        ClearStudentClassesEvent::class => [
            ClearStudentClassesListener::class,                   /* to delete classes of studnet */
            NotifyStudentParentFromSalesSupportAction::class      /* to inform customer about sales team action */
        ],
    ];

    protected $observers = [
        RescheduleRequest::class => [RescheduleObserver::class],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Course::observe(CourseObserver::class);
        RescheduleRequest::observe(RescheduleObserver::class);

      
    }
}
