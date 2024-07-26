<?php

namespace App\Http\Requests\Frontend;

use App\Constants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ForgetPasswordEmailRequest extends FormRequest
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
            'email' => [
                'required',
                'email',
                Rule::exists('members','email'),
                Rule::unique('members','email')->where(function ($query){
                    return $query
                        ->WHERE('status','=',Constants::MEMBER_BANNED_STATUS);
                })
            ]
        ];
    }

    public function messages(){
        return [
            'email.required'    => 'Please fill your email',
            'email.email'       => 'Please fill valid email format',
            'email.exists'      => 'Wrong email',
            'email.unique'      => 'This email is banned by administrator'
        ];
    }
}
