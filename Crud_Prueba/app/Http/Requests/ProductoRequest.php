<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
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
            'name'=>'required|min:4|max:150',
            'brand'=>'required|min:4|max:50',
            'category'=>'required|min:4|max:50',
            'price'=>'required|numeric|between:0,99999.99',
            'details'=>'required|min:10',
        ];
    }
}
