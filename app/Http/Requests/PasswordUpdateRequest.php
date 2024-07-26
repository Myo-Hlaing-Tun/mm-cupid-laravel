<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordUpdateRequest extends FormRequest
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
                'min:8'
            ],
            'confirm_password' => [
                'required',
                'same:password'
            ],
        ];
    }

    public function messages(){
        return [
            'password.required'         => 'Please fill password',
            'password.min'              => 'Password must be at least 8 in length',
            'confirm_password.required' => 'Please fill confirm password',
            'confirm_password.same'     => 'Password and confirm password do not match',
        ];
    }
}
