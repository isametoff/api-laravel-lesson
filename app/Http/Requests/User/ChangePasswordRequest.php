<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'bail|required|min:6|regex:/^\S+$/u',
            'new_password' => 'bail|required|min:6|regex:/^\S+$/u|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'required|min:6|regex:/^\S+$/u'
        ];
    }
}
