<?php

namespace App\Http\Requests\TeacherCoordinator;

use App\Models\LibraryFile;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFileNameRequest extends FormRequest
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
            'file_id'=>['required','numeric','exists:library_files,id'],
            'file_name'=>['required','string', 'unique:library_files,title,'.$this->file_id.',id,deleted_at,NULL'],
            
        ];
    }

    public function withValidator($validator)
    {
        if (!$validator->fails()) {
            $validator->after(function ($validator) {
                    // check whether the given folder id is under coordinator or not 
                    if (LibraryFile::find($this->file_id)->created_by!=auth()->id()) {  // kia yeh file isi teacher coordinator n create ki h ya nhe 
                        $validator->errors()->add('File', 'The Given File Does Not Belong To You');
                    }
               
            });
        }
    }

}
