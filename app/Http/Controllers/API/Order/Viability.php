<?php

namespace App\Http\Controllers\API\Order;

use App\Actions\Orders\Index;
use App\Actions\Orders\Viability as ActionViability;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\ViabilityRequest;

class Viability extends Controller
{
    public function __invoke(ViabilityRequest $request, ActionViability $actionViability)
    {
        return $actionViability($request['ids']);
    }
}