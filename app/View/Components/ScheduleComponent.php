<?php

namespace App\View\Components;

use App\Traits\FilterClassTrait;
use Carbon\Carbon;
use Illuminate\View\Component;

class ScheduleComponent extends Component
{
    use FilterClassTrait;
    public $model;
    public $timezone;

    public $classes;
    public $liveClass=[];
    public $todayClasses=[];
    public $nextClasses=[];
    public $previousClasses;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model)
    {
        //
        $this->model = $model;
        $this->timezone=$model->timezone;
        $this->previousClasses=collect([]);
      
        $this->classes = $this->model->weekly_classes()->with('Student')->whereDate('class_time', '>', Carbon::now()->subMonth())->get()->filter(function($value,$key){
            return !is_null($value->student);
        });

        $this->SchedulefilterClasses();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
      
        return view('components.schedule-component');
    }


}
