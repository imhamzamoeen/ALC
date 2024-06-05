<?php

namespace App\Http\Requests\TeacherCoordinator;

use App\Models\SharedLibrary;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFolderNameRequest extends FormRequest
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
            'id'=>['required','numeric', 'exists:shared_libraries,id'],
            'title'=>['required','string', 'unique:shared_libraries,title,'.$this->id.',id']
        ];
    }

    public function withValidator($validator)
    {
        if (!$validator->fails()) {
            $validator->after(function ($validator) {
                    // check whether the given folder id is under coordinator or not 
                    if (SharedLibrary::find($this->id)->created_by!=auth()->id()) {
                        $validator->errors()->add('Folder', 'The Given Folder Does Not Belong To You');
                    }
               
            });
        }
    }


}
