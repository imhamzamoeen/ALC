<?php

namespace App\Http\Requests\Student;

use App\Classes\Enums\UserTypesEnum;
use App\Models\Student;
use App\Models\User;
use App\Models\WeeklyClass;
use Illuminate\Foundation\Http\FormRequest;

class MakeStudentRescheduleRequest extends FormRequest
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
     * 
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'slot' => ['required', 'numeric', 'between:0,48'],
            'student_id' => ['required', 'numeric', 'exists:students,id'],
            'teacher_id' => ['required', 'numeric', 'exists:users,id'],
            'weekly_class_id' => ['required', 'numeric', 'exists:weekly_classes,id'],
            'reschedule_date' => ['required', 'date', 'after_or_equal:' . now()->startOfWeek()->format('Y-m-d ') . '', 'before_or_equal:' . now()->endOfWeek()->format('Y-m-d ') . '']    // the given date must be betwen ongoing week later we will add week for it 
        ];
    }

    public function withValidator($validator)
    {
        if (!$validator->fails()) {
            $validator->after(function ($validator) {
                if (Student::find($this->student_id)->teacher->id != $this->teacher_id)
                    $validator->errors()->add('Teacher', 'The Given Teacher Does Not Belong To You');           // check if the teacher has not given the wrong student id 

                if (WeeklyClass::whereId($this->weekly_class_id)->value('student_id') != $this->student_id)     // check that this weekly class belong to the logged in user 
                    $validator->errors()->add('Class', 'The Requested Class does not belong to you');
            });
        }
    }
}
