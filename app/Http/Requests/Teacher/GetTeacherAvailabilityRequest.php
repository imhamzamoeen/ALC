<?php

namespace App\Http\Requests\Teacher;

use App\Classes\Enums\UserTypesEnum;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class GetTeacherAvailabilityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasRole('teacher');
        /* here we will add any other person who wants to see availability of the teacher */
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'teacherid' => ['required', 'numeric', 'exists:users,id'],
        ];
    }


    // public function withValidator($validator)
    // {
    //     if (!$validator->fails()) {
    //         $validator->after(function ($validator) {
    //             if (User::whereId($this->teacherid)->value('user_type') != UserTypesEnum::Teacher)
    //                 $validator->errors()->add('User', 'The given id does not belong to a Teacher');
    //         });
    //     }
    // }
}
