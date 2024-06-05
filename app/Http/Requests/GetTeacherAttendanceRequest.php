<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class GetTeacherAttendanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasAnyRole(['teacher-coordinator']);
        //later we will decide whether we only customer teacher and who is authorized for this request
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'teacher_id' => ['required', 'numeric', 'exists:users,id'],
            'asking_id' => ['required', 'numeric', 'exists:users,id'],
        ];
    }


    // here we will add validator that student belong to respective parent or teacher 

    public function withValidator($validator)
    {
        if (!$validator->fails()) {
            $validator->after(function ($validator) {
                $asking_type = User::find($this->asking_id)->value('user_type');
                if ($asking_type == "teacher-coordinator" ) {
                    // later we will add condition for admin here 
                    // check if the asked teacher is under asking id's co ordination or not 
                    if (in_array($this->teacher_id, User::find($this->asking_id)->Teacher()->pluck('id')->toArray())==false) {
                        $validator->errors()->add('Teacher', 'The Given Teacher Does Not Belong To You');
                    }
                }
            });
        }
    }
}
