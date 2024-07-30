<?php

namespace App\Http\Requests\Frontend;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Rule;

class ViewMemberRequest extends BaseFormRequest
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
            'id' => [
                'required',
                'integer',
                Rule::exists('members','id')->where(function ($query){
                    return $query
                        ->WHERENULL('deleted_at');
                })
            ]
        ];
    }

    public function messages(){
        return [
            'id.required'   => 'Member id must not be empty',
            'id.integer'    => 'Member id must be integer',
            'id.exists'     => 'Request id does not exist in our database'
        ];
    }
}
