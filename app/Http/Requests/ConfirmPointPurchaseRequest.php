<?php

namespace App\Http\Requests;

use App\Rules\PointPurchaseRule;
use Illuminate\Foundation\Http\FormRequest;

class ConfirmPointPurchaseRequest extends FormRequest
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
            'point' => [
                'required',
                'numeric',
            ]
        ];
    }
    public function messages(){
        return [
            'point.required'    => 'Please fill amount of point to be added',
            'point.numeric'     => 'Point must be number',
        ];
    }
}
