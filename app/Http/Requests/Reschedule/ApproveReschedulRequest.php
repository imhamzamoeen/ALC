<?php

namespace App\Http\Requests\Reschedule;

use App\Models\RescheduleRequest;
use App\View\Components\Student\RequestReschedule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use LDAP\Result;

class ApproveReschedulRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //this can be done by teacher or student  depends on who putted the request
        return true;

        // later we will add that particular teacher and student of this reschedule class is authorized or not 
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'reschedule_class_id' => ['required', 'numeric', 'exists:reschedule_requests,id'],
            'weekly_class_id' => ['required', 'numeric', 'exists:weekly_classes,id'],
            'notification_id' => ['required', 'numeric', 'exists:notifications,id'],
            'student_id' => ['nullable', 'numeric', 'exists:students,id', Rule::requiredIf(empty($this->teacher_id)),],
            'teacher_id' => ['nullable', 'numeric', 'exists:users,id', Rule::requiredIf(empty($this->student_id)),],         // if both student and teacher id would be missing it will thorw error
        ];
    }


    public function withValidator($validator)
    {
        if (!$validator->fails()) {
            $validator->after(function ($validator) {
                if (!RescheduleRequest::when(empty($this->student_id), function ($query) {
                    return $query->where(['id' => $this->reschedule_class_id, 'teacher_id' => $this->teacher_id]);
                }, function ($query) {
                    return $query->where(['id' => $this->reschedule_class_id, 'student_id' => $this->student_id]);
                })->exists()){
                    //somebody has changed data .means no reschedule id against given teacher exists 
                    $validator->errors()->add("RescheduleRequest", 'The Class Does not belong to you');
                }
            });
        }
    }
}
