<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingStoreRequest extends FormRequest
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
            'point' => [
                'required',
                'integer'
            ],
            'company_name' => [
                'required'
            ],
            'company_email' => [
                'required',
                'email'
            ],
            'company_address' => [
                'required',
            ],
            'company_phone' => [
                'required',
            ],
            'company_logo' => [
                'required',
                'mimes:jpg,jpeg,png,gif'
            ]
        ];
    }
    public function messages(){
        return [
            'point.required'            => 'Please fill default point',
            'point.integer'             => 'Point must be integer',
            'company_name.required'     => 'Please fill company name',
            'company_email.required'    => 'Please fill company email',
            'company_email.email'       => 'Invalid company email format',
            'company_address.required'  => 'Please fill company address',
            'company_phone.required'    => 'Please fill company phone',
            'company_logo.required'     => 'Please upload company logo',
            'company_logo.mimes'        => 'Only JPG,JPEG,PNG and GIF files are accepted for company logo'
        ];
    }
}
