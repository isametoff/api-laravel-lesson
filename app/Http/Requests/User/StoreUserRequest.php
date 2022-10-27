<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Cart\ApiRequest;

class StoreUserRequest extends ApiRequest
{


    public function rules()
    {
        return [

            // В некоторых ситуациях вы можете захотеть выполнить проверку поля только в том
            // случае, если это поле присутствует в проверяемых данных. Чтобы быстро выполнить
            // это, добавьте "sometimes"

            'login' => 'required|string|min:6',
            'email' => 'required|email',
            'password' => 'required|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'required',

            // 'login' => 'required|string',
            // 'email' => 'required|email',
            // 'password' => 'required|min:6|required_with:password',
            // 'password_confirmation' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'required' => 'Это поле необходимо для заполнения',
            'nullable' => 'необходимо',
            'min' => 'Минимальное значение 6',
        ];
    }
}