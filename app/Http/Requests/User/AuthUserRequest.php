<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Cart\ApiRequest;
use App\Rules\Boolean;

class AuthUserRequest extends ApiRequest
{


    public function rules()
    {
        return [

            'login' => 'required|min:6|max:255',
            'password' => 'required|min:6|max:255',
            'isAuth' => 'required'


        ];
    }
    public function messages()
    {
        return [
            'login.required' => 'Введите логин',
            'password.required' => 'Введите пароль',
            'min' => 'Минимальное значение 6',
        ];
    }
}