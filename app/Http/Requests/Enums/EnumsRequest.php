<?php

namespace App\Http\Requests\Enums;

use Illuminate\Foundation\Http\FormRequest;

class EnumsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'column' => 'required|string|max:6',
            'search' => 'nullable',
            'stateSelect' => 'nullable|array',
        ];
    }
}
