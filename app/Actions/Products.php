<?php

namespace App\Actions;

use Illuminate\Support\Facades\Log;

class Products
{
    public static function filter($products, $data)
    {
        // Log::info($data);
        isset($data['zip']) && $data['zip'] && $data['zip'] != null ?
            $products = $products->where('zip', $data['zip']) : '';
        isset($data['sitySelect']) && $data['sitySelect'] && $data['sitySelect'][0] != null ?
            $products = $products->where(function ($query) use ($data) {
                foreach ($data['sitySelect'] as $sity) {
                    $query->orWhere('sity', 'LIKE', '%' . $sity . '%');
                }
            }) : '';
        isset($data['stateSelect']) && $data['stateSelect'] && $data['stateSelect'][0] != null ?
            $products = $products->whereIn('state', $data['stateSelect']) : '';
        isset($data['sexValue']) && $data['sexValue'] != null ? $products = $products->where('sex', $data['sexValue']) : '';
        isset($data['dlValue']) && $data['dlValue'] && $data['dlValue'] != null || $data['dlValue'] === false ?
            $data['dlValue'] === true ? $products = $products->whereNotNull('dl') : $products->whereNull('dl') : '';
        (isset($data['fromDob']) && isset($data['beforeDob']) && $data['fromDob'] != null && $data['beforeDob'] != null) ?
            $products = $products->whereBetween('dob_year', [$data['fromDob'], $data['beforeDob']]) : '';
        if (
            isset($data['firstName']) && $data['firstName'] != null
        ) {
            $firstName = str_replace(' ', '', $data['firstName']);
            $products = $products->where('first_name', "LIKE", "%{$firstName}%");
        };
        if (
            isset($data['lastName']) && $data['lastName'] != null
        ) {
            $lastName = str_replace(' ', '', $data['lastName']);
            $products = $products->where('last_name', "LIKE", "%{$lastName}%");
        };
        return $products;
    }
}
