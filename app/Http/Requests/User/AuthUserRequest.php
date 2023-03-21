<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class AuthUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'login' => 'bail|required|min:6|regex:/^\S+$/u|max:255',
            'password' => 'bail|required|min:6|regex:/^\S+$/u|max:255',
            'isAuth' => 'required'
        ];
    }
}
