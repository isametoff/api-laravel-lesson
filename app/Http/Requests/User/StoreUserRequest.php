<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{


    public function rules()
    {
        return [
            'login' => 'required|string|min:6|regex:/^\S+$/u|max:255|unique:users',
            'telegram' => 'required|string|regex:/^\S+$/u|max:255|unique:users',
            'password' => 'required|min:6|regex:/^\S+$/u
            |required_with:password_confirmation|same:password_confirmation|confirmed',
            'password_confirmation' => 'required|min:6|regex:/^\S+$/u',
            'register' => 'required',
        ];
    }
}
