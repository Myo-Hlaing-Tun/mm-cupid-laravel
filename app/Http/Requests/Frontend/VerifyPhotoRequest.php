<?php

namespace App\Http\Requests\Frontend;

use App\Http\Requests\BaseFormRequest;
use App\Rules\Base64Rule;

class VerifyPhotoRequest extends BaseFormRequest
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
