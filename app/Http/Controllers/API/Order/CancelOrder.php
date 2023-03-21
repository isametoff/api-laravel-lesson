<?php

namespace App\Http\Controllers\API\Order;

use App\Actions\Orders\Cancel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CancelOrder extends Controller
{
    public function all(Request $request, Cancel $cancelOrderAction)
    {
        return $cancelOrderAction->all(Auth::user()->id);
    }
}