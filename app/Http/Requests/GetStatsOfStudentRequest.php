<?php

namespace App\Http\Requests;

use App\Classes\Enums\UserTypesEnum;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use phpDocumentor\Reflection\PseudoTypes\False_;

class GetStatsOfStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasanyRole(['teacher', 'teacher-coordinator','customer']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'submonths' => ['required', 'numeric',],
            'studentid' => ['required', 'numeric', 'exists:students,id'],
            'asking_id' => ['required', 'numeric', 'exists:users,id'],

        ];
    }

    //with validator that only its' parent and teacher is requesting attendence

    public function withValidator($validator)
    {
        if (!$validator->fails()) {
            $validator->after(function ($validator) {
                $asking_type = User::whereId($this->asking_id)->value('user_type');
                if ($asking_type == "teacher") {
                    // if it's teacher or parent the given student must belong to them
                    if (in_array($this->studentid, User::find($this->asking_id)->Students()->pluck('id')->toArray()) == false) {
                        $validator->errors()->add('Student', 'The Given Student Does Not Belong To You');
                    }
                } elseif ($asking_type == "customer") {
                    // if it's teacher or parent the given student must belong to them
                    if (in_array($this->studentid, User::find($this->asking_id)->profiles()->pluck('id')->toArray()) == false) {
                        $validator->errors()->add('Student', 'The Given Student Does Not Belong To You');
                    }
                } elseif ($asking_type == "teacher-coordinator") {
                    // if it's teacher or parent the given student must belong to them
                    $teacher_ids = User::find($this->asking_id)->Teacher()->pluck('id');
                    Student::whereIn('teacher_id', $teacher_ids)->pluck('id');
                    if (in_array($this->studentid, Student::whereIn('teacher_id', $teacher_ids)->pluck('id')->toArray()) == false) {
                        $validator->errors()->add('Student', 'The Given Student Does Not Belong To You');
                    }
                }
            });
        }
    }
}
