<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PointManageRequest extends FormRequest
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
                'numeric'
            ],
            'action' => [
                'required',
                'numeric'
            ],
            'id'    => [
                'required',
                'numeric',
                Rule::exists('members', 'id')->where(function ($query){
                    return $query
                        ->WHERENULL('deleted_at');
                })
            ]
        ];
    }
    public function messages(){
        return [
            'point.required'        => 'Please fill the point',
            'point.numeric'         => 'Point must be number',
            'action.required'       => 'Please select an action',
            'action.numeric'        => 'Selected action must be number',
            'id.required'           => 'Member id must not be empty',
            'id.numeric'            => 'Member id must be a number',
            'id.exists'             => 'Requested member id does not exist in our database'
        ];
    }
}
