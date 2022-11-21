<?php

namespace App\Http\Requests\Order;

use App\Http\Requests\Cart\ApiRequest;

class AddingOrderRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules()
    {
        return [
            'order' => 'required|array',
        ];
    }
    public function messages()
    {
        return [
            'required' => 'Это поле необходимо для заполнения',
            'array' => 'array',
        ];
    }
}