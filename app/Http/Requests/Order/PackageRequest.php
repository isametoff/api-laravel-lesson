<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules()
    {
        return [
            'sexValue' => 'nullable',
            'fromDob' => 'nullable',
            'beforeDob' => 'nullable',
            'sitySelect' => 'nullable|array',
            'stateSelect' => 'nullable|array',
            'zip' => 'nullable',
            'plan' => 'required',
        ];
    }
}
