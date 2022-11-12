<?php

namespace App\Enums\Order;

enum Status: int
{
    case ONGOING = 0;
    case DELIVERED = 1;
    case CANCELED = 2;

    public function text()
    {
        return match ($this->value) {
            self::ONGOING->value => 'ONGOING',
            self::DELIVERED->value => 'DELIVERED',
            self::CANCELED->value => 'CANCELED'
        };
    }
}