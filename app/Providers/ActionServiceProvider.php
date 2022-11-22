<?php

namespace App\Providers;

use App\Actions\Orders\StoreOrder;
use App\Contracts\OrdersContract;
use Illuminate\Support\ServiceProvider;

class ActionServiceProvider extends ServiceProvider
{
    public array $bindings = [
        OrdersContract::class => StoreOrder::class
    ];
}