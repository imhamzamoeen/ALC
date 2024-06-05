<?php

namespace App\View\Components\TeacherCoordinator;

use App\Traits\FilterClassTrait;
use Illuminate\View\Component;

class RescheduleComponent extends Component
{
    use FilterClassTrait;
 
    /**
     * The alert message.
     *
     * @var string
     */
    public $Model;
    public $FreeSlots;
    public $BookedSlots;
    public $TotalSlots;
    public $CoordinatorSlots;  // this containt teacher's converted slots to student slots
    // public $StudentTime;  // this containt teacher's converted slots to student slots
    
 
    /**
     * Create the component instance.
     *
     * @param  string  $type
     * @param  string  $message
     * @return void
     */
    public function __construct($model)
    {
        $this->Model = $model;
        $this->FreeSlots = collect([]);
        $this->BookedSlots = collect([]);
        $this->TotalSlots = collect([]);
        $this->CoordinatorSlots = collect([]);
        $this->GetTeacherCoordinatorSlots();  //fill the above collections
        $this->MakeTeacherSlotForCoordinator();
 

    }
 

    /**
     * Create a new component instance.
     *
     * @return void
     */

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.teacher-coordinator.reschedule-component');
    }
}
