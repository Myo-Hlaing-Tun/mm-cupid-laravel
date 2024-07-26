<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
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
            'title' => [
                'required',
            ],
            'description' => [
                'required'
            ],
            'post_photo' => [
                'required',
                'mimes:jpg,jpeg,png,gif'
            ]
        ];
    }
    public function messages(){
        return [
            'title.required'          => 'Please fill post title',
            'description.required'    => 'Please fill post descriptions',
            'post_photo.required'     => 'Please upload post photo',
            'post_photo.mimes'        => 'Only JPG,JPEG,PNG and GIF files are accepted for post photo'
        ];
    }
}
