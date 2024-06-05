<?php

namespace App\View\Components\SalesSupport;

use App\Models\Student;
use App\Models\User;
use App\Traits\FilterClassTrait;
use Illuminate\View\Component;

class TeacherSlots extends Component
{
    use FilterClassTrait;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $date;
    public $Model;
    public $FreeSlots;
    public $BookedSlots;
    public $TotalSlots;
    public $StudentTime;  // this containt teacher's converted slots to student slots
    public function __construct($date,$teacher,$student)
    {
        //
        $this->date=$date;

        $this->Model = User::with('availability.days')->findOrFail($teacher);
        $this->student= Student::with('user','course')->findOrFail($student);
        $this->TotalSlots=collect([]);
        $this->FreeSlots = collect([]);
        $this->StudentTime = collect([]);
        $this->BookedSlots = collect([]);
        $this->GetTeacherSlots();  //fill the above collections
        $this->MakeTeacherSlotForStudentSales();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
            
        return view('components.sales-support.teacher-slots');
    }
}
