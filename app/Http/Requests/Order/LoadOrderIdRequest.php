<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class LoadOrderIdRequest extends FormRequest
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
}
