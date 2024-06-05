<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TeacherAssignedResourceComponent extends Component
{
    public $Model;
    public $first_time;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model,$first_time=NULL)
    {
        //
        $this->first_time=$first_time;
        $this->Model=$model;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.teacher-assigned-resource-component');
    }
}
