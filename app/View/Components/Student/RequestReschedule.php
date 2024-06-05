<?php

namespace App\View\Components\Student;

use Illuminate\View\Component;

class RequestReschedule extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $student;
    public $teacher;
    public function __construct($class="Null",$student)
    {
        $this->student = $student;
        $this->teacher = $student->teacher;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.student.request-reschedule');
    }
}
