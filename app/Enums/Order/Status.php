<?php

namespace App\Enums\Order;

enum Status: int
{
    case STORE = 0;
    case PAID = 1;

    public function text()
    {
        return match ($this->value) {
            self::STORE->value => 'STORE',
            self::PAID->value => 'PAID',
        };
    }
}