<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePhotoRequest extends FormRequest
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
            'file1' => [
                'nullable',
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
            'file1.mimes'               => 'Uploaded photo 1 must be JPG,JPEG,PNG or GIF file type',
            'file2.mimes'               => 'Uploaded photo 2 must be JPG,JPEG,PNG or GIF file type',
            'file3.mimes'               => 'Uploaded photo 3 must be JPG,JPEG,PNG or GIF file type',
            'file4.mimes'               => 'Uploaded photo 4 must be JPG,JPEG,PNG or GIF file type',
            'file5.mimes'               => 'Uploaded photo 5 must be JPG,JPEG,PNG or GIF file type',
            'file6.mimes'               => 'Uploaded photo 6 must be JPG,JPEG,PNG or GIF file type'
        ];
    }
}
