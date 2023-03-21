<?php

namespace App\Http\Controllers;

use App\Actions\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HelloController extends Controller
{
    public function __invoke(Request $request)
    {
        // Log::info($request);
        return Transaction::index($request);
    }
}