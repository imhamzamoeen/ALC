<?php

namespace App\Listeners;

use App\Events\ClearStudentClassesEvent;
use App\Models\Student;
use App\Models\WeeklyClass;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClearStudentClassesListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    // public $details;
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

    /* no need of constructor as it is getting a straigt event in handle funciton */
    public function handle(ClearStudentClassesEvent $event)
    {
        //

        try {
            DB::transaction(function () use ($event) {

                $StudentModel = Student::query()->findOrFail($event->details['student_id']);
                WeeklyClass::where('student_id', $event->details['student_id'])->where('class_time', '<', now())->delete();    // delete only classes that have passed 
                $StudentModel->routine_classes()->delete();   // deleting the weekly classes of the student
            });
        } catch (Exception $e) {
            Log::info("User Clear Classes Failed");
            Log::info($e->getMessage());
        }
    }
}
