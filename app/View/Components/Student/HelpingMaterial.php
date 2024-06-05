<?php

namespace App\View\Components\Student;

use Illuminate\View\Component;

class HelpingMaterial extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $student;
    public $folders;
    public function __construct($student)
    {
        $this->student = $student;

        foreach ($student->files as $file){
            $this->folders[$file->sharedLibrary->title][] = $file;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.student.helping-material');
    }
}
