<?php

namespace App\Http\Requests\Frontend;

use App\Http\Requests\BaseFormRequest;

class PostsPageRequest extends BaseFormRequest
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
            'page' => [
                'required',
                'numeric'
            ]
        ];
    }
    public function messages(){
        return [
            'page.required' => 'Page must not be empty',
            'page.numeric'  => 'Page number must be a number'
        ];
    }
}
