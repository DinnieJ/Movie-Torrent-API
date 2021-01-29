<?php

namespace App\Http\Requests\Car;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateCarRequest extends FormRequest
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

            'id' => 'required|integer|exists:cars,id',
            'model' => 'required',
            'year' => 'required|integer|between:1997,2020'

        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'ID of car is required',
            'id.exists' => 'ID này không tồn tại',
            'model.required' =>  'Model field is required',
            'year.required'  => 'Year field is required',
            'year.between' => 'Year must be between 1997 and 2020'


        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));

    }
}
