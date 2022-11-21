<?php

namespace App\Enums\Order;

enum Status: int
{
    case WAITING = 0;
    case CANCELED = 1;
    case DELIVERED = 2;
    case ADDED = 3;

    public function text()
    {
        return match ($this->value) {
            self::WAITING->value => 'WAITING',
            self::CANCELED->value => 'CANCELED',
            self::DELIVERED->value => 'DELIVERED',
            self::ADDED->value => 'ADDED',
        };
    }
}