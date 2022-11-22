<?php

namespace App\Contracts;

interface OrdersContract
{
    public function __invoke(array $data): int;
}
