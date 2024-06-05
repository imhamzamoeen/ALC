<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class HelpAndSupportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasRole('customer');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'=>['required','email'],
            'subject'=>['required','string','max:50'],
            'details'=>['required','string'],
        ];
    }

    public function validated(): array
    {
        
            return array_merge(parent::validated(), ['name' =>auth()->user()->name]);
           
        return parent::validated();
    }
}
