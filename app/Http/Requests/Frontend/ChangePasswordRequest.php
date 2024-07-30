<?php

namespace App\Http\Requests\Frontend;

use App\Http\Requests\BaseFormRequest;
use App\Rules\PasswordCorrectRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
class ChangePasswordRequest extends BaseFormRequest
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
            'oldpassword' => [
                'required',
                new PasswordCorrectRule(Auth::guard('member')->user()->email,$this->oldpassword)
            ],
            'newpassword' => [
                'required',
                'min:8'
            ],
        ];
    }
    public function messages(){
        return [
            'oldpassword.required'  => 'Please fill old password',
            'newpassword.required'  => 'Please fill new password',
            'newpassword.min'       => 'New password must be at least 8 in length'
        ];
    }
}
