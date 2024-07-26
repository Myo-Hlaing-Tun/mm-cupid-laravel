<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserStoreRequest extends FormRequest
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
            'username' => [
                'required',
                'regex:/^[a-zA-Z0-9_]+$/',
                Rule::unique('users','username')->where(function ($query){
                    return $query
                        ->WHERENULL('deleted_at');
                })
            ],
            'password' => [
                'required',
                'min:8'
            ],
            'confirm_password' => [
                'required',
                'same:password'
            ],
            'role' => [
                'required',
                'integer'
            ],
        ];
    }

    public function messages(){
        return [
            'username.required'         => 'Please fill username',
            'username.regex'            => 'Username must be words and digits only(no space and special characters)',
            'username.unique'           => 'Username already exists',
            'password.required'         => 'Please fill password',
            'password.min'              => 'Password must be at least 8 in length',
            'confirm_password.required' => 'Please fill confirm password',
            'confirm_password.same'     => 'Password and confirm password do not match',
            'role.required'             => 'Please select user role',
            'role.integer'              => 'Selected user role must be integer'
        ];
    }
}
