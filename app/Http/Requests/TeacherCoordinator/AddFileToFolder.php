<?php

namespace App\Http\Requests\TeacherCoordinator;

use App\Models\SharedLibrary;
use Illuminate\Foundation\Http\FormRequest;

class AddFileToFolder extends FormRequest
{
    protected $stopOnFirstFailure = true;
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
            'filepond'=>['required','file',],
            'folder_id'=>['required','numeric','exists:shared_libraries,id']
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
            });
        }
    }
}
