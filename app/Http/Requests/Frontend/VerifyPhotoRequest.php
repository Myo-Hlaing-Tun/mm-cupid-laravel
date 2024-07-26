<?php

namespace App\Http\Requests\Frontend;

use App\Rules\Base64Rule;
use Illuminate\Foundation\Http\FormRequest;

class VerifyPhotoRequest extends FormRequest
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
            'src' => [
                'required',
                new Base64Rule($this->src)
            ]
        ];
    }
}
