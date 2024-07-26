<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HobbyUpdateRequest extends FormRequest
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
            'hobby' => [
                'required',
                Rule::unique('hobbies','name')->where(function ($query){
                    return $query
                        ->WHERE("id","!=", $this->id)
                        ->WHERENULL('deleted_at');
                })
            ]
        ];
    }
    public function messages(){
        return [
            'hobby.required' => 'Please fill hobby name',
            'hobby.unique' => 'Hobby name already exists',
        ];
    }
}
