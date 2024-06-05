<?php

namespace App\Http\Requests\TeacherCoordinator;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class GetStudentOfTeacherRequest extends FormRequest
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
            'teacher_id' => ['required', 'numeric', 'exists:users,id'],
            'asking_id' => ['required', 'numeric', 'exists:users,id'],
        ];
    }

    public function withValidator($validator)
    {
        if (!$validator->fails()) {
            $validator->after(function ($validator) {
                $asking_type = User::find($this->asking_id)->value('user_type');
                if ($asking_type == "teacher-coordinator") {
                    // if it's teacher or parent the given student must belong to them

                    if (in_array($this->teacher_id, User::find($this->asking_id)->Teacher()->pluck('id')->toArray()) == False) {
                        $validator->errors()->add('Teacher', 'The Given Teacher Does Not Belong To You');
                    }
                }
            });
        }
    }
}
