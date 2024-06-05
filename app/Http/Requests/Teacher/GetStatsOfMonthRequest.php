<?php

namespace App\Http\Requests\Teacher;

use App\Classes\Enums\UserTypesEnum;
use Illuminate\Foundation\Http\FormRequest;

class GetStatsOfMonthRequest extends FormRequest
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
            'submonths'=>['required','numeric','max:0','min:-11'],
            'teacherid'=>['required','numeric','exists:users,id'],

        ];
    }

    //withvalidator we will add that teacherid must be of a user type teacher
}
