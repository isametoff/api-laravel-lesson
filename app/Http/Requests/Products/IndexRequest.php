<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
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
        ];
    }
}
