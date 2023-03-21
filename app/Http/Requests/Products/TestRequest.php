<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class TestRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'perPage' => 'required|integer',
            'pageValue' => 'required|integer',
            'columnSort' => 'required|string',
            'bySort' => 'required|string',
            'sexValue' => 'nullable',
            'dlValue' => 'nullable',
            'fromDob' => 'nullable',
            'beforeDob' => 'nullable',
            'firstName' => 'nullable',
            'lastName' => 'nullable',
            'sitySelect' => 'nullable|array',
            'stateSelect' => 'nullable|array',
            'zip' => 'nullable',
        ];
    }
}
