<?php

namespace App\Http\Requests\Order;

use App\Http\Requests\Cart\ApiRequest;

class NullOrderIdRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules()
    {
        return [];
    }
}