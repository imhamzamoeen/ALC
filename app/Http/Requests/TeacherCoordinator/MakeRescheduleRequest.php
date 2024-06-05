<?php

namespace App\Http\Requests\TeacherCoordinator;

use App\Models\User;
use App\Models\WeeklyClass;
use Illuminate\Foundation\Http\FormRequest;

class MakeRescheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasRole('teacher-coordinator');
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
            'slot' => ['required', 'numeric', 'between:0,48'],
            'teacher_id' => ['required', 'numeric', 'exists:users,id'],
            'student_id' => ['required', 'numeric', 'exists:students,id'],
            'weekly_class_id' => ['required', 'numeric', 'exists:weekly_classes,id'],
            'reschedule_date' => ['required', 'date', 'after_or_equal:' . now()->startOfWeek()->format('Y-m-d ') . '', 'before_or_equal:' . now()->endOfWeek()->format('Y-m-d ') . '']    // the given date must be betwen ongoing week later we will add week for it 
        ];
    }

    public function withValidator($validator)
    {
        if (!$validator->fails()) {
            $validator->after(function ($validator) {
                if (User::find($this->teacher_id)->coordinated_by != auth()->id())   // here auth()->id is the id of the teacher coordinator
                    $validator->errors()->add('Teacher', 'The Given Teacher Does Not Belong To You');           // check if the teacher has not given the wrong student id 

                if (in_array($this->student_id, User::find($this->teacher_id)->Students()->pluck('id')->toArray()) == false) {
                    $validator->errors()->add('Student', 'The Given Student Does Not Belong To Teacher');
                }
                $weekly_class = WeeklyClass::find($this->weekly_class_id);
                if ($weekly_class->teacher_id != $this->teacher_id || $weekly_class->student_id != $this->student_id )   // here auth()->id is the id of the teacher coordinator
                    $validator->errors()->add('Class', 'The Given Class Doen not belong to you');
            });
        }
    }
}
