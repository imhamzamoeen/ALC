<?php

namespace App\View\Components;

use Carbon\Carbon;

use App\Classes\Enums\StatusEnum;
use Illuminate\View\Component;
use App\Classes\Enums\UserTypesEnum;

class TimeLineComponent extends Component
{
    public $model;
    public $classes;
    public $liveClass;
    public $todayClasses;
    public $nextClasses;
    public $timezone;
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public function __construct($model)
    {
        // if($model instanceof App\Model)
        $this->model = $model;
        $this->classes = $this->model->weekly_classes()->with('Student:id,name,timezone,course_id,teacher_id,user_id')->whereDate('class_time', '>', Carbon::yesterday())->get()->filter(function($value,$key){
            return !is_null($value->student);
        });
        $this->filterClasses();
        $this->timezone =$this->model->timezone;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.time-line-component');
    }

    public function filterClasses()
    {
        $timezone =  $this->model->timezone;
        foreach ($this->classes as $class) {
            $class->class_time = convertTimeToUSERzone($class->class_time,  $timezone);
            $class->live_status = 0;

            $tempTime = Carbon::parse($class->class_time)->addMinutes(31);
            $live = Carbon::now($timezone)->between(Carbon::parse($class->class_time)->subMinute(), $tempTime);

            if (Carbon::now($timezone)->gt($tempTime)) {
                if ($class->teacher_status != StatusEnum::PRESENT) {
                    $class->teacher_status = StatusEnum::ABSENT;
                }
            }

            if ($live) {
                $class->live_status = 1;
                $class->status = beautify_slug(StatusEnum::ONGOING);
                $this->liveClass[] = $class;
            }
            if ($class->class_time->gt(Carbon::today($timezone)->subMinute()) && !$class->class_time->gt(Carbon::tomorrow($timezone)->subMinutes())) {
                $this->todayClasses[] = $class;
            } elseif ($class->class_time->gt(Carbon::tomorrow($timezone)->subMinute())) {
                $this->nextClasses[] = $class;
            }
        }
    }
}
