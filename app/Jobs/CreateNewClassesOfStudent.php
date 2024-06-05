<?php

namespace App\Jobs;

use App\Models\WeeklyClass;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Classes\AlQuranConfig;
use App\Models\Student;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class CreateNewClassesOfStudent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;



    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * The maximum number of unhandled exceptions to allow before failing.
     *
     * @var int
     */
    public $maxExceptions = 3;


    public $timeout = 120;


    public $failOnTimeout = true;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $details;
    public function __construct($details)
    {
        //
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {

            DB::transaction(function () {
                $students = Student::Has('user')->Has('teacher')->where('id', $this->details['student_id'])->whereIsSubscribed(1)->get();
                Log::info("inside call");


                $classData = array();
                foreach ($students as $student) {
                    Log::info("found a student ");

                    $routine_classes = $student->load('routine_classes');
                    $routine_classes = $routine_classes->routine_classes;
                    $teacher = $student->teacher;
                    $weeklyClasses = $student->weekly_classes()->get();
                    if ($routine_classes->isNotEmpty()) {
                        foreach ($routine_classes as $routine_class) {
                            $classSlot = $routine_class->availability_slot;
                            if (is_null($classSlot->day)) {

                                continue;
                            } else {
                                $day = $classSlot->day->day_id;
                                $teacherTimezone = $teacher->timezone;
                                $slot = get_24_hour_timeslots(false, $classSlot->slot_id);
                                $teacherTime = \Carbon\Carbon::parse($slot, $teacherTimezone);
                                $utcClassTime = convertTimeToUTCzone($teacherTime, $teacherTimezone);
                                $teacher_time = Carbon::now($teacherTimezone)->startOfWeek()->addDay($day)->toDateString();   // start of the week returns the monday of ongoing week and we will are doing -1 because our 1 is monday
                                $time = convert_slot_to_time_of_a_date($teacher_time, $classSlot->slot_id, 'Y-m-d H:i:s');
                                $class_time = convertTimeToUTCzone($time, $teacherTimezone);
                                $thisWeekCheck = $weeklyClasses->where('class_time', $class_time)->first();
                                if (is_null($thisWeekCheck)) {
                                    $classData[] = [
                                        'student_id'        => $student->id,
                                        'teacher_id'        => $teacher->id,
                                        'routine_class_id'  => $routine_class->id,
                                        'class_time'        => $class_time->toDateTimeString(),
                                        'class_link'        => createZoomLinkByClassTime($class_time),
                                        'created_at' =>  Carbon::now(),
                                        'session_key' => CreateUUId(),
                                    ];
                                }
                                $nextWeekCheck = $weeklyClasses->where('class_time', $class_time->addWeek())->first();
                                if (is_null($nextWeekCheck)) {
                                    $classData[] = [
                                        'student_id'        => $student->id,
                                        'teacher_id'        => $teacher->id,
                                        'routine_class_id'  => $routine_class->id,
                                        'class_time'        => $class_time->toDateTimeString(),
                                        'class_link'        => createZoomLinkByClassTime($class_time->addWeek()),
                                        'created_at' =>  Carbon::now(),
                                        'session_key' => CreateUUId(),

                                    ];
                                }
                            }
                        }
                    }
                }
                Log::info($classData);
                WeeklyClass::insert($classData);
            });
        } catch (Exception $e) {
            Log::info("inside quik class failed");
            Log::info($e);
        }
    }
}
