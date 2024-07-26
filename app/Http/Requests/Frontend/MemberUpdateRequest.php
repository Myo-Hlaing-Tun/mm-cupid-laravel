<?php

namespace App\Http\Requests\Frontend;

use App\Http\Requests\BaseFormRequest;

class MemberUpdateRequest extends BaseFormRequest
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
            'username'      => [
                'required',
            ],
            'phone'         => [
                'required',
            ],
            'date_of_birth' => [
                'required',
                'regex:/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/',
            ],
            'height_feet'   => [
                'required',
                'numeric'
            ],
            'height_inches' => [
                'required',
                'numeric'
            ],
            'city'          => [
                'required',
                'numeric'
            ],
            'education'     => [
                'required',
            ],
            'about'         => [
                'required',
            ],
            'work'          => [
                'required',
            ],
            'gender'        => [
                'required',
                'numeric'
            ],
            'hobbies_arr'       => [
                'required',
            ],
            'min_age'       => [
                'required',
                'numeric'
            ],
            'max_age'       => [
                'required',
                'numeric'
            ],
            'pgender'       => [
                'required',
                'numeric'
            ],
            'religion'      => [
                'required',
                'numeric'
            ]
        ];
    }
    public function messages(){
        return [
            'username.required'         => 'Please fill username',
            'phone.required'            => 'Please fill user phone',
            'date_of_birth.required'    => 'Please select user date of birth',
            'date_of_birth.regex'       => 'Date of birth must be in format of YYYY-MM-DD',
            'height_feet.required'      => 'Please select height in feet',
            'height_feet.numeric'       => 'Height in feet must be a number',
            'height_inches.required'    => 'Please select height in inches',
            'height_inches.numeric'     => 'Height in inches must be a number',
            'city.required'             => 'Please select user city',
            'city.numeric'              => 'Selected city must be number',
            'education.required'        => 'Please fill user education',
            'about.required'            => 'Please fill about yourself in brief',
            'work.required'             => 'Please fill user work',
            'gender.required'           => 'Please select user gender',
            'gender.numeric'            => 'Selected gender must ba a number',
            'hobbies_arr.required'      => 'Please select user hobbies',
            'min_age.required'          => 'Please select partner minimum age',
            'min_age.numeric'           => 'Partner minimum age must be number',
            'max_age.required'          => 'Please select partner maximum age',
            'max_age.numeric'           => 'Partner maximum age must be number',
            'pgender.required'          => 'Please select partner gender',
            'pgender.numeric'           => 'Selected partner gender must be number',
            'religion.required'         => 'Please select user religion',
            'religion.numeric'          => 'Selected religion must be number',
        ];
    }
}
