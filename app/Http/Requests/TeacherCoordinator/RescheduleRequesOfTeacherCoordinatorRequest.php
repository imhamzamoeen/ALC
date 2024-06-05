<?php

namespace App\Http\Requests\TeacherCoordinator;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class RescheduleRequesOfTeacherCoordinatorRequest extends FormRequest
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
            'teacherid' => ['required', 'numeric', 'exists:users,id'],
            'studentid' => ['required', 'numeric', 'exists:students,id'],
        ];
    }

    public function withValidator($validator)
    {
        if (!$validator->fails()) {
            $validator->after(function ($validator) {
                if (User::find($this->teacherid)->coordinated_by != auth()->id())   // here auth()->id is the id of the teacher coordinator
                    $validator->errors()->add('Teacher', 'The Given Teacher Does Not Belong To You');           // check if the teacher has not given the wrong student id 

                if (in_array($this->studentid, User::find($this->teacherid)->Students()->pluck('id')->toArray()) == false) {
                    $validator->errors()->add('Student', 'The Given Student Does Not Belong To Teacher');
                }
            });
        }
    }
}
