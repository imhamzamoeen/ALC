<?php

namespace App\Http\Requests\TeacherCoordinator;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class GetNotificationForCoordinatorRequest extends FormRequest
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
            'date'=>['required','date','after_or_equal:'.Carbon::now()->subMonth()->format('m/d/y').'','before_or_equal:'.Carbon::today()->format('m/d/y').'']    // aj s eik month peechy tk 
        ];
    }
}
