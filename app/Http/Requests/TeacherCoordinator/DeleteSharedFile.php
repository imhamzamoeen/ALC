<?php

namespace App\Http\Requests\TeacherCoordinator;

use App\Models\Shareable;
use Illuminate\Foundation\Http\FormRequest;

class DeleteSharedFile extends FormRequest
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
            'shared_id'=>['required','numeric','exists:shareables,id']
        ];
    }


}
