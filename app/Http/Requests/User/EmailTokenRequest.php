<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Cart\ApiRequest;

class EmailTokenRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules()
    {
        return [
            'email_token' => 'required|string',
        ];
    }
}