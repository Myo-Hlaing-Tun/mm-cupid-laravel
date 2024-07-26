<?php

namespace App\Http\Requests\Frontend;

use App\Http\Requests\BaseFormRequest;

class SyncMembersRequest extends BaseFormRequest
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
                'required',
                'integer'
            ],
            'search_gender' => [
                'nullable',
                'integer',
                'gt:0',
                'lt:4'
            ],
            'search_min_age' => [
                'nullable',
                'integer',
                'gte:18',
                'lte:55'
            ],
            'search_max_age' => [
                'nullable',
                'integer',
                'gte:18',
                'lte:55'
            ]
        ];
    }

    public function messages(){
        return [
            'page.required'             => 'Page number is empty',
            'page.integer'              => 'Page number must be integer',
            'search_gender.integer'     => 'Partner gender must be integer',
            'search_gender.gt'          => 'Search gender must be 1 to 3',
            'search_gender.lt'          => 'Search gender must be 1 to 3',
            'search_min_age.integer'    => 'Partner minimum age must be integer',
            'search_min_age.gte'         => 'Partner age must be 18 years to 55 years',
            'search_min_age.lte'         => 'Partner age must be 18 years to 55 years',
            'search_max_age.integer'    => 'Partner maximum age must be integer',
            'search_max_age.gte'         => 'Partner age must be 18 years to 55 years',
            'search_max_age.lte'         => 'Partner age must be 18 years to 55 years',
        ];
    }
}
