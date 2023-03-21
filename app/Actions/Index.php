<?php

namespace App\Actions;

use App\Models\OrderProducts;

class Index
{
    static function getYearFromDate($date)
    {
        $dateParts = explode('/', $date);
        foreach ($dateParts as $key => $value) {
            if (strlen($value) > 3) {
                return $value;
            }
        };
    }
    static function getReplaceCharacters($data)
    {
        dd($data);
        $one = str_replace(',', '|', $data);
        $one = str_replace('{', ',', $one);
        $one = str_replace('}', ',', $one);
        $one = str_replace('"', '', $one);
        return $one = str_replace("\n", ' ', $one);
    }
}
