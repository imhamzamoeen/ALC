<?php

namespace App\View\Components\Customer;

use App\Traits\FilterClassTrait;
use Illuminate\View\Component;

class CustomizeSubscription extends Component
{
    use FilterClassTrait;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $student;
    public $teacher;
    public $type;
    public $teacherClasses;
    public $Model;
    public $FreeSlots;
    public $BookedSlots;
    public $TotalSlots;
    public $StudentTime;  // this containt teacher's converted slots to student slots
    public $cardInfo;
    public $planPrice;

    public function __construct($type, $student, $model,$cardInfo,$planPrice)
    {
     
        $this->type = $type;
        $this->student = $student;
        $this->teacher = $student->teacher;
        $this->teacherClasses = $this->teacher->teacherClasses->pluck('slot_id')->toArray() ?? array();
        $this->Model = $model;
        $this->TotalSlots=collect([]);
        $this->FreeSlots = collect([]);
        $this->StudentTime = collect([]);
        $this->BookedSlots = collect([]);
        $this->cardInfo = $cardInfo;
        $this->planPrice = $planPrice;
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
        return view('components.customer.customize-subscription');
    }
}
