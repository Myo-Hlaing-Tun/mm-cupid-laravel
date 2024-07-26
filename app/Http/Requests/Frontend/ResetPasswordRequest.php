<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'password' => [
                'required',
                'min:8',
            ],
            'cf-password' => [
                'required',
                'same:password'
            ],
            'code' => [
                'required',
                'string',
                'min:32',
                'max:32',
                Rule::exists('members','forget_password_token')
            ]
        ];
    }

    public function messages(){
        return [
            'password.required'     => 'Please fill the password',
            'password.min'          => 'Password must be at least 8 in length', 
            'cf-password.required'  => 'Please fill confirm password',
            'cf-password.same'      => 'Password and confirm password do not match',
            'code.required'         => 'Reset code must not be empty',
            'code.string'           => 'Reset code must be string',
            'code.min'              => 'Reset code must be 32 in length', 
            'code.max'              => 'Reset code must be 32 in length',
            'code.exists'           => 'Wrong code'
        ];
    }
}
