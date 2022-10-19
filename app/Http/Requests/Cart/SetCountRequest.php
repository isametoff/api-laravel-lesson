<?php

namespace App\Http\Requests\Cart;


 class SetCountRequest extends ApiRequest
{

     public function rules()
    {
        return [
            'id' => 'required|numeric',
            'oldToken' => 'required|max:40|min:40',
            'cnt' => 'required|numeric',
        ];
    }
    public function messages()
    {
        return [
            'required' => 'Это поле необходимо для заполнения',
            'max|max' => 'max|max',
            'cnt' => 'max|max',
        ];
    }
}