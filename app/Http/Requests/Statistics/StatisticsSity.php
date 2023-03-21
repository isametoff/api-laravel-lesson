<?php

namespace App\Http\Requests\Statistics;


use Illuminate\Foundation\Http\FormRequest;

class StatisticsSity extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules()
    {
        return [
            'period' => 'nullable|array',
            'quantity' => 'integer',
            'page' => 'integer',
        ];
    }
}
