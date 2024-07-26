<?php

namespace App\Http\Requests\Frontend;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class ConfirmCodeRequest extends BaseFormRequest
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
                'min:32',
                'max:32',
                Rule::exists('members','forget_password_token')
            ]
        ];
    }

    public function messages(){
        return [
            'code.required'     => 'Reset code must not be empty',
            'code.string'       => 'Reset code must be string',
            'code.min'          => 'Reset code must be 32 in length', 
            'code.max'          => 'Reset code must be 32 in length',
            'code.exists'       => 'Wrong code'
        ];
    }
}
