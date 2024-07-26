<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
                        ->WHERE('id',"!=",$this->id)
                        ->WHERENULL('deleted_at');
                })
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
            'username.regex'            => 'Username must not include space or special character',
            'username.unique'           => 'Username already exists',
            'role.required'             => 'Please select user role',
            'role.integer'              => 'Selected user role must be integer'
        ];
    }
}
