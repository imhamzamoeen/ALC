<?php

namespace App\View\Components\Student;

use App\Traits\FilterClassTrait;
use Illuminate\View\Component;

class StuentRescheduleComponent extends Component
{
    use FilterClassTrait;
    public $Model;
    public $FreeSlots;
    public $BookedSlots;
    public $TotalSlots;
    public $StudentTime;  // this containt teacher's converted slots to student slots
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($Model)
    {
        $this->Model = $Model;
        $this->TotalSlots=collect([]);
        $this->FreeSlots = collect([]);
        $this->StudentTime = collect([]);
        $this->BookedSlots = collect([]);
        $this->GetStudentSlots();  //fill the above collections
        $this->MakeTeacherSlotForStudent();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */

    public function render()
    {
        return view('components.student.stuent-reschedule-component');
    }
}
