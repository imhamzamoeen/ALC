<?php

namespace App\Observers;

use App\Jobs\SendRescheduleMailJob;
use App\Models\RescheduleRequest;

class RescheduleObserver
{

    // public $afterCommit = true;    //only run after db commit
    /**
     * Handle the RescheduleRequest "created" event.
     *
     * @param  \App\Models\RescheduleRequest  $rescheduleRequest
     * @return void
     */
    public function created(RescheduleRequest $rescheduleRequest)
    {
        //

      
    }

    /**
     * Handle the RescheduleRequest "updated" event.
     *
     * @param  \App\Models\RescheduleRequest  $rescheduleRequest
     * @return void
     */
    public function updated(RescheduleRequest $rescheduleRequest)
    {
        //

        // dd ($rescheduleRequest);
        // $details['email'] = 'haamzaaay@gmail.com';
  
        // dispatch(new SendRescheduleMailJob($details));

    }

    /**
     * Handle the RescheduleRequest "deleted" event.
     *
     * @param  \App\Models\RescheduleRequest  $rescheduleRequest
     * @return void
     */
    public function deleted(RescheduleRequest $rescheduleRequest)
    {
        //
    }

    /**
     * Handle the RescheduleRequest "restored" event.
     *
     * @param  \App\Models\RescheduleRequest  $rescheduleRequest
     * @return void
     */
    public function restored(RescheduleRequest $rescheduleRequest)
    {
        //
    }

    /**
     * Handle the RescheduleRequest "force deleted" event.
     *
     * @param  \App\Models\RescheduleRequest  $rescheduleRequest
     * @return void
     */
    public function forceDeleted(RescheduleRequest $rescheduleRequest)
    {
        //
    }
}
