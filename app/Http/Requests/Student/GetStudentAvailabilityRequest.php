<?php

namespace App\Http\Requests\Student;

use App\Classes\Enums\UserTypesEnum;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class GetStudentAvailabilityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return UserTypesEnum::Customer == auth()->user()->user_type;
        /* here we will add any other person who wants to see availability of the student */
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'studentid' => ['required', 'numeric', 'exists:students,id'],
        ];
    }


    public function withValidator($validator)
    {
        //check that the given student'id belongs to the logged in parent
        if (!$validator->fails()) {
            $validator->after(function ($validator) {
                if (in_array($this->studentid, User::find(auth()->id())->profiles()->pluck('id')->toArray()) == false) {
                    $validator->errors()->add('Student', 'The Given Student Does Not Belong To You');
                }
            });
        }
    }
}
