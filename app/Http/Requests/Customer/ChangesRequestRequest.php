<?php

namespace App\Http\Requests\Customer;

use App\Classes\Enums\UserTypesEnum;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Validator;

class ChangesRequestRequest extends FormRequest
{

    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasRole(UserTypesEnum::Customer);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'reason' => ['required', 'string', 'max:150',],
            'change_type' => ['required', 'string', 'in:teacher_change,course_change'],
            'course_id' => ['sometimes', Rule::requiredIf($this->change_type == 'course_change'),],
            'course_title' => ['sometimes', Rule::requiredIf($this->course_id == 'custom'),],
            'course_description' => ['sometimes', Rule::requiredIf($this->course_id == 'custom'), 'string', 'min:5', 'max:150'],
        ];
    }




    protected function passedValidation()
    {
        $this->merge([
            'status' => 'pending',
            // 'student_id' => request()->child->id
        ]);
    }

    public function validated(): array
    {

        return array_merge(parent::validated(), [
            'status' => 'pending',
            // 'student_id' => request()->child->id
        ]);


        return parent::validated();
    }


    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            /* go in if only validator has not failed yet */
            if ($validator->errors()->isEmpty()) {
                $student=$this->route('child');
                if($this->change_type=='course_change' ){
                  if( optional(optional($student->latestChangeRequestOfCourse)->created_at)->isBetween(
                        Carbon::now()->startOfMonth(),
                        Carbon::now()
                    )){
                        $validator->errors()->add('Request Limit', 'You cannot make more than one request per month');
                    }
                }else{
                   if(  optional(optional($student->latestChangeRequestOfTeacher)->created_at)->isBetween(
                        Carbon::now()->startOfMonth(),
                        Carbon::now()
                        )){
                            $validator->errors()->add('Request Limit', 'You cannot make more than one request per month');
                        }
                }
               
            

            }
              
        });
    }
}
