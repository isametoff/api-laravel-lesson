<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Cart\ApiRequest;

class AuthUserRequest extends ApiRequest
{


    public function rules()
    {
        return [

            'login' => 'required|string|min:6|max:255',
            'password' => 'required|min:6|max:255',

        ];
    }
    public function messages()
    {
        return [
            'required' => 'Это поле необходимо для заполнения',
            'min' => 'Минимальное значение 6',
            'login.unique' => 'Такой логин уже существует ',
        ];
    }
}