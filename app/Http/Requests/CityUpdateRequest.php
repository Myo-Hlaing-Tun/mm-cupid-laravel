<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class CityUpdateRequest extends FormRequest
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
            'city_name' => [
                'required',
                Rule::unique('cities','name')->where(function ($query){
                    return $query
                        ->WHERE('id','!=',$this->id)
                        ->WHERENULL('deleted_at');
                })
            ]
        ];
    }

    public function messages(){
        return [
            'city_name.required' => 'Please fill city name',
            'city_name.unique' => 'City name already exists',
        ];
    }
}