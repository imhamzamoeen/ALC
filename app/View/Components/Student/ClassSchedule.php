<?php

namespace App\View\Components\Student;

use App\Classes\Enums\StatusEnum;
use Carbon\Carbon;
use Illuminate\View\Component;

class ClassSchedule extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $student;

    public $classes;
    public $liveClass;
    public $todayClasses;
    public $nextClasses;
    public $previousClasses;
    public $timezone;
    public $teacher_name;
    public $model;

    public $course_name;  //sice student can only read one course
    public function __construct($student)
    {
        $this->model = $student;
        $this->course_name = $student->course->title ?? '';
        $this->teacher_name = $student->teacher->name ?? '';   //since student has only one teacher so we are getting here
        $this->timezone = $student->timezone;
        $this->classes = $this->model->weekly_classes()->with('Teacher')->whereDate('class_time', '>', Carbon::now()->subMonth())->get()->filter(function($value,$key){
            return !is_null($value->Teacher);
        })->sortBy([['class_time', 'DESC'],]);
        $this->filterClasses();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.student.class-schedule');
    }

    public function filterClasses()
    {
        $timezone =  $this->timezone;
        foreach ($this->classes as $class) {
            $class->class_time = convertTimeToUSERzone($class->class_time,  $timezone);
            $class->live_status = 0;

            $tempTime = Carbon::parse($class->class_time)->addMinutes(31);
            $live = Carbon::now($timezone)->between(Carbon::parse($class->class_time)->subMinute(), $tempTime);
            /*if(Carbon::now($this->student->timezone)->gt($tempTime)){
                dd(Carbon::now($this->student->timezone), $tempTime);
            }*/
            //dd(Carbon::now($this->student->timezone), $tempTime);

            if ($live) {
                $class->live_status = 1;
                $class->status = beautify_slug(StatusEnum::ONGOING);
                $this->liveClass = $class;
            }
            if ($class->class_time->gt(Carbon::now($timezone)->subMinutes(30)) && !$class->class_time->gt(Carbon::now($timezone)->endOfDay())) {
                $this->todayClasses[] = $class;
            } elseif ($class->class_time->gt(Carbon::tomorrow($timezone)->subMinute())) {
                $this->nextClasses[] = $class;
            } elseif (Carbon::now($timezone)->gt($tempTime)) {
                // if ($class->teacher_status != StatusEnum::PRESENT) {
                //     $class->teacher_status = StatusEnum::ABSENT;
                // }
                // if ($class->student_status != StatusEnum::PRESENT) {
                //     $class->status = StatusEnum::CLASSMISSED;
                // } elseif ($class->teacher_status != StatusEnum::PRESENT) {
                //     $class->status = StatusEnum::TEACHERABSENT;
                // }
                $this->previousClasses[] = $class;
            }
            ;
        }
    }
}
