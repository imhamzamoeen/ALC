<?php

namespace App\Http\Requests\Teacher;

use App\Classes\Enums\UserTypesEnum;
use Illuminate\Foundation\Http\FormRequest;

class AssignResouceToStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return UserTypesEnum::Teacher==auth()->user()->user_type;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          
            'student_id'=>['required','numeric','exists:students,id'],
            'libray_files'=>['required','array'],
            'libray_files.*'=>['required','numeric','exists:library_files,id'],
        ];
    }
}
