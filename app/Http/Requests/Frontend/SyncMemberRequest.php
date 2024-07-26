<?php

namespace App\Http\Requests\Frontend;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class SyncMemberRequest extends BaseFormRequest
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
            'page'     => [
                'nullable',
                'integer'
            ],
            'id'       => [
                'required',
                'integer',
                Rule::exists('members','id')
            ]
        ];
    }

    public function messages(){
        return [
            'page.integer'              => 'Page number must be integer',
            'id.required'               => 'Member id must not be empty',
            'id.integer'                => 'Member id must be number',
            'id.exists'                 => 'Member id does not exist in our database',
        ];
    }
}
