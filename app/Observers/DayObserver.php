<?php

namespace App\Observers;

use App\Models\Day;

class DayObserver
{
    /**
     * Handle the Day "created" event.
     *
     * @param  \App\Models\Day  $day
     * @return void
     */
    public function created(Day $day)
    {
        //
    }

    /**
     * Handle the Day "updated" event.
     *
     * @param  \App\Models\Day  $day
     * @return void
     */
    public function updated(Day $day)
    {
        //
    }

    /**
     * Handle the Day "deleted" event.
     *
     * @param  \App\Models\Day  $day
     * @return void
     */
    public function deleted(Day $day)
    {
        $day->slots->delete();
    }

    /**
     * Handle the Day "restored" event.
     *
     * @param  \App\Models\Day  $day
     * @return void
     */
    public function restored(Day $day)
    {
        //
    }

    /**
     * Handle the Day "force deleted" event.
     *
     * @param  \App\Models\Day  $day
     * @return void
     */
    public function forceDeleted(Day $day)
    {
        //
    }
}
