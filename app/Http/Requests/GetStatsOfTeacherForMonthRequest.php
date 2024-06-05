<?php

namespace App\Http\Requests;

use App\Classes\Enums\UserTypesEnum;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class GetStatsOfTeacherForMonthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasanyRole(['teacher-coordinator']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'submonths' => ['required', 'numeric', 'max:0', 'min:-11'],
            'teacherid' => ['required', 'numeric', 'exists:users,id'],
            'asking_id' => ['required', 'numeric', 'exists:users,id'],

        ];
    }

    //with validator that only its' parent and teacher is requesting attendence

    public function withValidator($validator)
    {
        if (!$validator->fails()) {
            $validator->after(function ($validator) {
                $asking_type = User::find($this->asking_id)->value('user_type');
                if ($asking_type == "teacher-coordinator") {
                    // if it's teacher or parent the given student must belong to them

                    if (in_array($this->teacherid, User::find($this->asking_id)->Teacher()->pluck('id')->toArray()) == False) {
                        $validator->errors()->add('Teacher', 'The Given Teacher Does Not Belong To You');
                    }
                }
            });
        }
    }
}
