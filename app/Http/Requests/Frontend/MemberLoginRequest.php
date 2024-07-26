<?php

namespace App\Http\Requests\Frontend;

use App\Rules\UserLoginEnableRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MemberLoginRequest extends FormRequest
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
            'email'     => [
                'required',
                'email',
                Rule::exists('members','email')
            ],
            'password'  => [
                'required',
                'min:8',
                new UserLoginEnableRule($this->email, $this->password)
            ],
        ];
    }

    public function messages(){
        return [
            'email.required'    => 'Please Fill email',
            'email.email'       => 'Login email must be email format',
            'email.exists'      => 'Wrong email',
            'password.required' => 'Please fill password',
            'password.min'      => 'Password must be at least 8 in length'
        ];
    }
}
