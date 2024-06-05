<?php

namespace App\Console\Commands;

use App\Classes\AlQuranConfig;
use App\Jobs\SendJobErrorMailJob;
use App\Models\Student;
use App\Models\WeeklyClass;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Webpatser\Uuid\Uuid;

class createNewWeeklyClasses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create_weekly_classes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {

            DB::transaction(function () {


                // $thisSunday = Carbon::parse('this sunday');   // return next given date when this day occur on calender  
                // $nextSunday = Carbon::parse('this sunday')->addWeek();  // next sunday after this week

                $students = Student::Has('user')->has('teacher')->whereIsSubscribed(1)->get();
                $classData = array();
                foreach ($students as $student) {
                    //    $this->info('Student Fetched: ID:'.$student->id);
                    $this->info("student going:" . $student->name . " of teacher " . $student->teacher->name);
                    $routine_classes = $student->load('routine_classes');
                    $routine_classes = $routine_classes->routine_classes;
                    // $this->info($routine_classes);
                    $teacher = $student->teacher;
                    $weeklyClasses = $student->weekly_classes()->get();

                    if ($routine_classes->isNotEmpty()) {
                        //    $this->info(count($routine_classes).' Routine Classes found for student ID:'.$student->id);
                        foreach ($routine_classes as $routine_class) {

                            $classSlot = $routine_class->availability_slot;
                            // $this->info($classSlot);
                            // $this->info($student->name);
                            if (is_null($classSlot->day)) {
                                // $this->info("khali");
                                continue;
                            } else {

                                $day = $classSlot->day->day_id;
                                // $this->info($day . ' is day ');
                                // $teacherTimezone = $teacher->availability->timezone;
                                $teacherTimezone = $teacher->timezone;


                                $slot = get_24_hour_timeslots(false, $classSlot->slot_id);
                                // $this->info('slot we get ' . $slot);
                                $teacherTime = \Carbon\Carbon::parse($slot, $teacherTimezone);
                                // $this->info('teacher time we get ' . $teacherTime);
                                // $this->info('teacher timezone ' . $teacherTimezone);

                                $utcClassTime = convertTimeToUTCzone($teacherTime, $teacherTimezone);
                                // $this->info('utc time we get ' . $utcClassTime);


                                // $teacher_time = Carbon::now($teacherTimezone)->startOfWeek()->addDay($day - 1)->toDateString();   // start of the week returns the monday of ongoing week and we  are doing -1 because our 1 is monday so 1-1 will make monday to monday 
                                $teacher_time = Carbon::now($teacherTimezone)->startOfWeek()->addDay($day)->toDateString();   // start of the week returns the monday of ongoing week and we will are doing -1 because our 1 is monday
                                // $this->info("teacher taime:" . $teacher_time);
                                $time = convert_slot_to_time_of_a_date($teacher_time, $classSlot->slot_id, 'Y-m-d H:i:s');
                                // $this->info("time after adding days" . $time);
                                $class_time = convertTimeToUTCzone($time, $teacherTimezone);
                                // $this->info("Aftering converitng above taime to utc" . $class_time);

                                // $this->info('class time we get' . $class_time);

                                /* old talha bhai */
                                // $thisWeekClassTime = Carbon::parse('this ' . AlQuranConfig::Days[$day] . ' ' . $utcClassTime);
                                // $this->info('this class time time we get'.$thisWeekClassTime);
                                // $this->info('actual class time time we get'.$thisWeekClassTime->toDateTimeString());

                                /* old talha bhai */



                                $thisWeekCheck = $weeklyClasses->where('class_time', $class_time)->first();
                                if (is_null($thisWeekCheck)) {
                                    $this->info("first week check");
                                    $this->info(" ");

                                    $classData[] = [
                                        'student_id'        => $student->id,
                                        'teacher_id'        => $teacher->id,
                                        'routine_class_id'  => $routine_class->id,
                                        'class_time'        => $class_time->toDateTimeString(),
                                        'class_link'        => createZoomLinkByClassTime($class_time),
                                        'created_at' =>  Carbon::now(),
                                        'session_key' => $this->GetUniqueSessionKey(),
                                    ];
                                }

                                $nextWeekCheck = $weeklyClasses->where('class_time', $class_time->addWeek())->first();
                                if (is_null($nextWeekCheck)) {
                                    $this->info("second week check");
                                    $this->info(" ");

                                    $classData[] = [
                                        'student_id'        => $student->id,
                                        'teacher_id'        => $teacher->id,
                                        'routine_class_id'  => $routine_class->id,
                                        'class_time'        => $class_time->toDateTimeString(),
                                        'class_link'        => createZoomLinkByClassTime($class_time->addWeek()),
                                        'created_at' =>  Carbon::now(),
                                        'session_key' => $this->GetUniqueSessionKey(),

                                    ];
                                }
                            }
                        }
                    }
                }
                // Log::info($classData);
                WeeklyClass::insert($classData);
            });
        } catch (Exception $e) {
            // DB::rollback();
            $this->info($e);
            Log::info($e);
            SendJobErrorMailJob::dispatch([
                'function' => 'Create weekly Classes Cron job error',
                'message' => $e->getMessage(),
            ]);
        }
    }
    private function GetUniqueSessionKey()
    {
        $code = '';
        do {
            $code = (string) Uuid::generate();
            $code[0]="W";
            $code[1]="K";
            $user_code = WeeklyClass::where('session_key', $code)->exists();
        } while ($user_code);
        return $code;
    }
}
