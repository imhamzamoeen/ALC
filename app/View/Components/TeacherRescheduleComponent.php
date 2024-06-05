<?php

namespace App\View\Components;

use App\Traits\FilterClassTrait;
use Illuminate\View\Component;

class TeacherRescheduleComponent extends Component
{
    use FilterClassTrait;
    public $Model;
    public $FreeSlots;
    public $BookedSlots;
    public $TotalSlots;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($Model)
    {
        $this->Model=$Model;
        $this->TotalSlots=collect([]);
        $this->FreeSlots=collect([]);
        $this->BookedSlots=collect([]);
        $this->GetTeacherSlots();  //fill the above collections
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.teacher-reschedule-component');
    }
}
