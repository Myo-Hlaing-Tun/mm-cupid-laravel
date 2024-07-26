<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmailConfirmRequest extends FormRequest
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
            'code' => [
                'required',
                'string',
                'size:32',
                Rule::exists('members','email_confirm_code')->where(function ($query){
                    return $query
                        ->WHERENULL('deleted_at');
                })
            ]
        ];
    }

    public function messages(){
        return [
            'code.required' => 'Email confirm code must not be empty',
            'code.string'   => 'Email confirm code must be string',
            'code.size'     => 'Email confirm code must be 32 in length',
            'code.exists'   => 'Wrong email confirm code'
        ];
    }
}
