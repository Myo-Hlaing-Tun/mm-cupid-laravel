<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class PointPurchaseRequest extends FormRequest
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
            'screenshot' => [
                'required',
                'mimes:jpg,jpeg,png,gif'
            ],
        ];
    }
    public function messages(){
        return [
            'screenshot.required'   => 'Screenshot must not be empty',
            'screenshot.mimes'      => 'Screemshot must be JPG,JPEG,PNG or GIF file type'
        ];
    }
}
