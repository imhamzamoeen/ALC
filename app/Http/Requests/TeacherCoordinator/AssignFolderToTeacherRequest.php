<?php

namespace App\Http\Requests\TeacherCoordinator;

use App\Models\SharedLibrary;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class AssignFolderToTeacherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasRole('teacher-coordinator');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'teacher_id'=>['required','numeric','exists:users,id'],
            'folder_id'=>['required','numeric','exists:shared_libraries,id'],
        ];
    }

    public function withValidator($validator)
    {
        if (!$validator->fails()) {
            $validator->after(function ($validator) {
                // check whether the given folder id is under coordinator or not 
                if (SharedLibrary::find($this->folder_id)->created_by != auth()->id()) {  // kia yeh file isi teacher coordinator n create ki h ya nhe 
                    $validator->errors()->add('Folder', 'The Given File Does Not Belong To You');
                }
                if (in_array($this->teacher_id, User::find(auth()->id())->Teacher()->pluck('id')->toArray()) == False) {
                    $validator->errors()->add('Teacher', 'The Given Teacher Does Not Belong To You');
                }
            });
        }
    }
}
