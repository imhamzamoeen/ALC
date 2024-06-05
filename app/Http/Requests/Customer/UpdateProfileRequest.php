<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UpdateProfileRequest extends FormRequest
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
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email,' . auth()->id() . ',id'],
            'password' => ['nullable', Password::min(8),],
            'phone' => ['nullable', 'string', 'max:20', 'min:8'],
            'customer_pin' => ['nullable', 'size:4'],
            'pin_check' => ['sometimes','required', 'boolean'],
        ];
    }


    protected function passedValidation()
    {
        if (!is_null($this->password)) {
            $this->merge(
                ['password' => Hash::make($this->input('password'))]
            );
        }
        if (!is_null($this->customer_pin)) {
            $this->merge(
                ['customer_pin' => Hash::make($this->input('customer_pin'))]
            );
        }
        if (is_null($this->pin_check)) {
           
            $this->merge(
                ['pin_check' => 0]
            );
        }
    }

    public function validated(): array
    {
        if (!is_null($this->password)) {
            return array_merge(parent::validated(), ['password' => $this->input('password')]);
        }
        if (!is_null($this->customer_pin)) {
            return array_merge(parent::validated(), ['customer_pin' => $this->input('customer_pin')]);
        }
        if (!array_key_exists('pin_check',parent::validated())) {
                
            return array_merge(parent::validated(), ['pin_check' => 0]);
            
        }
        return parent::validated();
    }
}
