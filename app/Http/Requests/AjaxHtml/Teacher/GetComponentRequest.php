<?php

namespace App\Http\Requests\AjaxHtml\Teacher;

use Illuminate\Foundation\Http\FormRequest;
use App\Classes\Enums\UserTypesEnum;

class GetComponentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return UserTypesEnum::Teacher==auth()->user()->user_type;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'page'=>['required']
        ];
    }
}
