<?php

namespace App\View\Components;

use App\Models\Student;
use Illuminate\View\Component;

class AttendanceComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $Model;
    public $Asking;
    public function __construct($Model, $Asking = NULL)
    {
        $this->Model = $Model;
        $this->Asking = !is_null($Asking) ? $Asking : ['name'=>'unknown',];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.attendance-component');
    }
}
