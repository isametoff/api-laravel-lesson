<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class Download extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            // return $request['text'];
            // $file = Storage::disk('public')->get($request['text']);
            return response()->download('storage/' . $request['text']);
            return response()->download(url('storage/' . $request['text']));
            return Storage::download(url('storage/' . $request['text']));
        } catch (\Exception $e) {
            dd($e);
        }
    }
}