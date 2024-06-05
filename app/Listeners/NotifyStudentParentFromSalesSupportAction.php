<?php

namespace App\Listeners;

use App\Events\ClearStudentClassesEvent;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotifyStudentParentFromSalesSupportAction implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    // protected $details;
    // public function __construct($details)
    // {
    //     //
    //     $this->details = $details;
    // }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ClearStudentClassesEvent  $event
     * @return void
     */
    public function handle(ClearStudentClassesEvent $event)
    {
        //  

        try{

            Mail::send('emails.partials.customer.changerequest.mail', ["details" =>  $event->details] , function ($message) use ($event) {
                $message->to( $event->details['user_email'])->subject('AlQuran Change Request For ' . beautify_slug($event->details['change_type']));
            });

        }catch(Exception $e){
            Log::info("User Clear Classes parent Email Send  Failed");
            Log::info($e->getMessage());
        }
    }
}
