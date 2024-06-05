<?php

namespace App\View\Components\TeacherCoordinator;

use App\Models\User;
use Illuminate\View\Component;

class EachFolderFilesComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $Model;
    public $Teachers;
    public function __construct($Model)
    {
        //
        $this->Model = $Model->clone()->first();
        $this->Teachers = User::select('id', 'name',)->whereId(auth()->id())->with(['Teacher' => function ($query) {
            $query->select('id', 'name', 'coordinated_by');
        },'Teacher.shareableLibraries'=>function ($query){
            $query->where('shared_library_id',$this->Model->id);
        },])->first();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.teacher-coordinator.each-folder-files-component');
    }
}
