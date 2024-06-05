<?php

namespace App\Http\Requests;

use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class GetAttendanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasanyRole(['teacher','customer','teacher-coordinator']);
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
            'student_id' => ['required', 'numeric', 'exists:students,id'],
            'asking_id' => ['required', 'numeric', 'exists:users,id'],
        ];
    }


    // here we will add validator that student belong to respective parent or teacher 

    public function withValidator($validator)
    {
        if (!$validator->fails()) {
            $validator->after(function ($validator) {
                $asking_type = User::whereId($this->asking_id)->value('user_type');
                if ($asking_type == "teacher") {
                    // if it's teacher or parent the given student must belong to them
                    if (in_array($this->student_id, User::find($this->asking_id)->Students()->pluck('id')->toArray())==false) {
                        $validator->errors()->add('Student', 'The Given Student Does Not Belong To You');
                    }
                }
                elseif($asking_type == "customer") {
                    // if it's teacher or parent the given student must belong to them
                    if (in_array($this->student_id, User::find($this->asking_id)->profiles()->pluck('id')->toArray())==false) {
                        $validator->errors()->add('Student', 'The Given Student Does Not Belong To You');
                    }
                }
                elseif($asking_type == "teacher-coordinator") {
                    // if it's teacher or parent the given student must belong to them
                    $teacher_ids= User::find($this->asking_id)->Teacher()->pluck('id');
                      Student::whereIn('teacher_id', $teacher_ids)->pluck('id');
                    if (in_array($this->student_id,Student::whereIn('teacher_id', $teacher_ids)->pluck('id')->toArray())==false) {
                        $validator->errors()->add('Student', 'The Given Student Does Not Belong To You');
                    }
                }
            });
        }
    }
}
