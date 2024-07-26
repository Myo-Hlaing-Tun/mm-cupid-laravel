<?php

namespace App\Http\Requests\Frontend;

use App\Http\Requests\BaseFormRequest;

class DeletePhotoRequest extends BaseFormRequest
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
            'sort' => [
                'required',
                'numeric'
            ]
        ];
    }
    public function messages(){
        return [
            'sort.required' => 'Photo number is required',
            'sort.numeric'  => 'Photo number must be numeric',
        ];
    }
}