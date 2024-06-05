<?php

namespace App\View\Components\Student;

use App\Classes\Enums\StatusEnum;
use Carbon\Carbon;
use Illuminate\View\Component;

class Timeline extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $student;
    public $model;
    public $classes;
    public $liveClass;
    public $todayClasses;
    public $nextClasses;
    public $timezone;
    public function __construct($student)
    {
        $this->model=$student;
        $this->timezone=$this->model->timezone;
        // $this->student = $student;
        $this->classes =  $this->model->weekly_classes()->with('Teacher')->whereDate('class_time', '>', Carbon::yesterday())->get()->filter(function($value,$key){
            return !is_null($value->Teacher);
        });
        $this->filterClasses();


    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.student.timeline');
    }

    public function filterClasses(){
        $timezone= $this->timezone;
        foreach ($this->classes as $class){
            $class->class_time = convertTimeToUSERzone($class->class_time,   $timezone);
            $class->live_status = 0;

            $tempTime = Carbon::parse($class->class_time)->addMinutes(31);
            $live = Carbon::now(  $timezone)->between(Carbon::parse($class->class_time)->subMinute(), $tempTime);

            if(Carbon::now(  $timezone)->gt($tempTime)){
                if($class->teacher_status != StatusEnum::PRESENT){
                    $class->teacher_status = StatusEnum::ABSENT;
                }
            }

            if($live){
                $class->live_status = 1;
                $class->status = beautify_slug(StatusEnum::ONGOING);
                $this->liveClass[] = $class;
            }
            if($class->class_time->gt(Carbon::today( $timezone)->subMinute()) && !$class->class_time->gt(Carbon::tomorrow(  $timezone))){
                $this->todayClasses[] = $class;
            }elseif($class->class_time->gt(Carbon::tomorrow(  $timezone)->subMinute())){
                $this->nextClasses[] = $class;
            }
        }
    }
}
