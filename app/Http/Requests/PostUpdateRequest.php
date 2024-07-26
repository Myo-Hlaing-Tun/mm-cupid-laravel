<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
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
                'nullable',
                'mimes:jpg,jpeg,png,gif'
            ]
        ];
    }
    public function messages(){
        return [
            'title.required'          => 'Please fill post title',
            'description.required'    => 'Please fill post descriptions',
            'post_photo.mimes'        => 'Only JPG,JPEG,PNG and GIF files are accepted for post photo'
        ];
    }
}
