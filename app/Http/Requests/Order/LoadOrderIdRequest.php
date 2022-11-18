<?php

namespace App\Http\Requests\Order;

use App\Http\Requests\Cart\ApiRequest;

class LoadOrderIdRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules()
    {
        return [
            'orderId' => 'required|numeric',
        ];
    }
    public function messages()
    {
        return [
            'required' => 'Это поле необходимо для заполнения',
        ];
    }
}
