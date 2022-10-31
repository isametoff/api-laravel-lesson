<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Cart\ApiRequest;

class StoreUserRequest extends ApiRequest
{


    public function rules()
    {
        return [
            'login' => 'required|string|min:6|max:255|unique:users',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|required_with:password_confirmation|same:password_confirmation|confirmed',
            'password_confirmation' => 'required',
            'register' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'required' => 'Это поле необходимо для заполнения',
            'min' => 'Минимальное значение 6',
            'login.unique' => 'Такой логин уже существует ',
            'email.unique' => 'Такой email уже существует',
        ];
    }
}
