<?php

namespace App\Http\Requests\Cart;


class LoadRequest extends ApiRequest
{


    public function rules()
    {
        return [
            'oldToken' => 'nullable',
        ];
    }
    public function messages()
    {
        return [
            'required' => 'Это поле необходимо для заполнения',
            'nullable' => 'необходимо',
            'max|max' => 'max|max',
        ];
    }
}
