<?php

namespace App\Http\Requests\Car;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateCarRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            //
            'model'=> 'required',
            'year' => 'required|integer|between:1997,2020'
        ];
    }
    public function messages()
    {
        return [
            'model.required' => 'Model is required',
            'year.required' => 'Year is required',
            'year.between' => 'Year must be between 1997 to 2020 !!',

        ];
    }
    protected function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json($validator->errors(), 422));

    }
}
