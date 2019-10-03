<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'   => 'sometimes|string',
            'type'   => 'sometimes|string',
            'brand'  => 'sometimes|string',
            'amount' => 'sometimes|between:0,999999999.99',
            'stock'  => 'sometimes|between:0,99999999999',
        ];
    }
}
