<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class EditPostRequest extends FormRequest
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
            'title' => 'required|string',
            'body' => 'required|string',
            'status' => 'required|integer',
        ];
    }
}
