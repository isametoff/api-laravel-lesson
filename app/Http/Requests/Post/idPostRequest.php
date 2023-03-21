<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class idPostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules()
    {
        return [
            'id' => 'required|integer',
        ];
    }
}
