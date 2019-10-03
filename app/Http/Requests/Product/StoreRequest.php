<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'              => 'required|string',
            'type'              => 'required|string',
            'brand'             => 'required|string',
            'amount'            => 'required|between:0,999999999.99',
            'stock'             => 'required|between:0,99999999999',
        ];
    }
}
