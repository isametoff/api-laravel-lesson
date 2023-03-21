<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Cart\ApiRequest;

class UserIdRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules()
    {
        return [
            'userId' => 'required|numeric',
        ];
    }
}