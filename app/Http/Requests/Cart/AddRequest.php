<?php

namespace App\Http\Requests\Cart;


class AddRequest extends ApiRequest
{

    public function rules()
    {
        return [
            'oldToken' => 'required|max:40|min:40',
            'id' => 'required|numeric',
        ];
    }
    public function messages()
    {
        return [
            'required' => 'Это поле необходимо для заполнения',
            'max|max' => 'max|max',
        ];
    }
}