<?php

namespace App\Http\Requests\Frontend;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class MemberDetailsStoreRequest extends BaseFormRequest
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
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('members','email')->where(function ($query){
                    return $query
                        ->WHERENULL('deleted_at');
                })
            ],
            'password' => [
                'required',
                'min:8'
            ],
            'phone' => [
                'required',
            ],
            'date_of_birth' => [
                'required',
                'regex:/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/',
            ],
            'height_feet' => [
                'required',
                'numeric'
            ],
            'height_inch' => [
                'required',
                'numeric'
            ],
            'city' => [
                'required',
                'numeric'
            ],
            'education' => [
                'required',
            ],
            'about' => [
                'required',
            ],
            'work' => [
                'required',
            ],
            'gender' => [
                'required',
                'numeric'
            ],
            'hobbies' => [
                'required',
            ],
            'min_age' => [
                'required',
                'numeric'
            ],
            'max_age' => [
                'required',
                'numeric'
            ],
            'pgender' => [
                'required',
                'numeric'
            ],
            'religion' => [
                'required',
                'numeric'
            ],
            'file1' => [
                'required',
                'mimes:jpg,jpeg,png,gif'
            ],
            'file2' => [
                'nullable',
                'mimes:jpg,jpeg,png,gif'
            ],
            'file3' => [
                'nullable',
                'mimes:jpg,jpeg,png,gif'
            ],
            'file4' => [
                'nullable',
                'mimes:jpg,jpeg,png,gif'
            ],
            'file5' => [
                'nullable',
                'mimes:jpg,jpeg,png,gif'
            ],
            'file6' => [
                'nullable',
                'mimes:jpg,jpeg,png,gif'
            ],
        ];
    }

    public function messages(){
        return [
            'username.required'         => 'Please fill username',
            'email.required'            => 'Please fill user email',
            'email.email'               => 'Email must be email format',
            'password.required'         => 'Please fill password',
            'password.min'              => 'Password must be at least 8 in length',
            'phone.required'            => 'Please fill user phone',
            'date_of_birth.required'    => 'Please select user date of birth',
            'date_of_birth.regex'       => 'Date of birth must be in format of YYYY-MM-DD',
            'height_feet.required'      => 'Please select height in feet',
            'height_feet.numeric'       => 'Height in feet must be a number',
            'height_inch.required'    => 'Please select height in inches',
            'height_inch.numeric'     => 'Height in inches must be a number',
            'city.required'             => 'Please select user city',
            'city.numeric'              => 'Selected city must be number',
            'education.required'        => 'Please fill user education',
            'about.required'            => 'Please fill about yourself in brief',
            'work.required'             => 'Please fill user work',
            'gender.required'           => 'Please select user gender',
            'gender.numeric'            => 'Selected gender must ba a number',
            'hobbies.required'          => 'Please select user hobbies',
            'min_age.required'          => 'Please select partner minimum age',
            'min_age.numeric'           => 'Partner minimum age must be number',
            'max_age.required'          => 'Please select partner maximum age',
            'max_age.numeric'           => 'Partner maximum age must be number',
            'pgender.required'          => 'Please select partner gender',
            'pgender.numeric'           => 'Selected partner gender must be number',
            'religion.required'         => 'Please select user religion',
            'religion.numeric'          => 'Selected religion must be number',
            'file1.required'            => 'Please upload photo in first box',
            'file1.mimes'               => 'Uploaded photo 1 must be JPG,JPEG,PNG or GIF file type',
            'file2.mimes'               => 'Uploaded photo 2 must be JPG,JPEG,PNG or GIF file type',
            'file3.mimes'               => 'Uploaded photo 3 must be JPG,JPEG,PNG or GIF file type',
            'file4.mimes'               => 'Uploaded photo 4 must be JPG,JPEG,PNG or GIF file type',
            'file5.mimes'               => 'Uploaded photo 5 must be JPG,JPEG,PNG or GIF file type',
            'file6.mimes'               => 'Uploaded photo 6 must be JPG,JPEG,PNG or GIF file type'
        ];
    }
}
