<?php

namespace App\View\Components\TeacherCoordinator;

use App\Traits\FilterClassTrait;
use Carbon\Carbon;
use Illuminate\View\Component;

class ScheduleComponent extends Component
{
    use FilterClassTrait;
    public $model;
    public $timezone;

    public $classes;
    public $liveClass = [];
    public $todayClasses = [];      // in this case we will add user and teacher detail with class
    public $nextClasses = [];
    public $previousClasses;
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public function __construct($model)
    {
        $this->model = $model;
        $this->classes = collect([]);
        $this->timezone = $model->timezone;
        $this->previousClasses = collect([]);
        foreach ($model->teacher as $eachteacher) {
            foreach ($eachteacher->weekly_classes as $eachweeklyclassofteacher) {
                $eachweeklyclassofteacher->teacher_name = $eachteacher->name;
                $eachweeklyclassofteacher->teacher_id = $eachteacher->id;

                $this->classes->push($eachweeklyclassofteacher);
            }
        }
        $this->classes =    $this->classes->sortBy('class_time');
        $this->SchedulefilterClasses();  // this is different as we add extra details to classes
       

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.teacher-coordinator.schedule-component');
    }
}
