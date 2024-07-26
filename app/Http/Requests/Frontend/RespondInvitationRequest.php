<?php

namespace App\Http\Requests\Frontend;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RespondInvitationRequest extends BaseFormRequest
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
            'response' => [
                'required'
            ],
            'id' => [
                'required',
                'numeric',
                Rule::exists('members','id')
            ]
        ];
    }
    public function messages(){
        return [
            'response.required' => 'Response must not be empty',
            'id.required'       => 'Id must be included',
            'id.numeric'        => 'Id must be member',
            'id.exists'         => 'Requested id does not exist in our database',
        ];
    }
}
