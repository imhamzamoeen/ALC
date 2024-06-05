<?php

namespace App\Console\Commands;

use App\Jobs\SendDailyClassesMailJob;
use App\Jobs\SendJobErrorMailJob;
use App\Models\WeeklyClass;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DailyClassesMailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DailyClass:Command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is used to send list of daily classes as an email to teacher and student ';

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
          
            $TeacherCollect = collect();
            $StudentCollect = collect();
            $classes = WeeklyClass::Has('teacher')->Has('Student.user')->select("*")->wherebetween('class_time', [Carbon::today('UTC')->subDay(), Carbon::today('UTC')->addDay()])->with([
                'Teacher' => function ($query) {
                    return $query->select('id', 'name');
                }, 'Student' => function ($query) {
                    return $query->select('id', 'name', 'course_id', 'user_id');
                }, 'Student.course' => function ($query) {
                    return $query->select('id', 'title');
                },
                'Student.user' => function ($query) {
                    return $query->select('id', 'name');
                }
            ])->get(); // because may be aj utc ki class student and teacher k kisi aur din ban rhi ho
     
            foreach ($classes as $key => $val) {

                $teacher_day = Carbon::today($val['teacher']['timezone'])->format('Y-m-d');  // teacher timezone
                $student_day = Carbon::today($val['student']['timezone'])->format('Y-m-d'); // teacher timezone
                $class_time = Carbon::parse(Carbon::parse($val->class_time)->format('Y-m-d')); //
                if ($class_time->eq($teacher_day)) {
                    $TeacherCollect->push($val);
                }
                if ($class_time->eq($student_day)) {
                    $StudentCollect->push($val);
                }
            }
            $TeacherCollect = $TeacherCollect->groupby('teacher.name');
            $StudentCollect = $StudentCollect->groupby('teacher_id');
            foreach ($StudentCollect as $key => $Studentclass) {
                $arr = array(
                    'mail' => $Studentclass[0]->student->user->email,
                    'user_type' => 'Student',
                    'date' => Carbon::parse($Studentclass[0]->weekly_class)->format('Y-m-d'),
                    'data' => [],
                );
                foreach ($Studentclass as $key => $val) {
                    $message = $val->student->name . '`s ' . $val->student->course->title . ' class at ' . convertTimeToUSERzone(Carbon::parse($val->class_time), $val->student->timezone)->format('Y-m-d h:i A') . ' with ' . $val->teacher->name;
                    array_push($arr['data'], $message);
                }
                SendDailyClassesMailJob::dispatch($arr);
            }
            foreach ($TeacherCollect as $key => $teacherclass) {
                $arr = array(
                    'mail' => $teacherclass[0]->teacher->email,
                    'user_type' => 'Teacher',
                    'date' => Carbon::parse($teacherclass[0]->weekly_class)->format('Y-m-d'),
                    'data' => [],
                );
                foreach ($teacherclass as $key => $val) {
                    $message = $val->student->name . '`s ' . $val->student->course->title . ' class at ' . convertTimeToUSERzone(Carbon::parse($val->class_time), $val->student->timezone)->format('Y-m-d h:i A');
                    array_push($arr['data'], $message);
                }
                SendDailyClassesMailJob::dispatch($arr);
            }
        } catch (Exception $e) {
            Log::error("Daily Classes Mail job failed");
            Log::debug($e->getMessage());
            SendJobErrorMailJob::dispatch([
                'function' => 'Daily classes timetable Cron job error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
