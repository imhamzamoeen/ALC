<?php

namespace App\View\Components\TeacherCoordinator;

use Illuminate\View\Component;

class TeacherStudentComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $Model;
    public function __construct($Model)
    {
        $this->Model = $Model;
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.teacher-coordinator.teacher-student-component');
    }
}
