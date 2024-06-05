<?php

namespace App\Http\Requests\Admin\TeacherCoordinator;

use Illuminate\Foundation\Http\FormRequest;

class AddAvailabilityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
       return auth()->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id'   => ['required','numeric','exists:users,id'],
            'timezone'  => ['required', 'max:50', 'string', 'not_in:0'],
        ];
    }


}
