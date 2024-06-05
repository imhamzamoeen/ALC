<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ClassStatsComponent extends Component
{
    public $Model;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($Model)
    {
        //
        $this->Model=$Model;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.class-stats-component');
    }
}
