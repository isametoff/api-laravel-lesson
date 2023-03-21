<?php

namespace App\Http\Controllers\API\Transaction;

use App\Actions\Transaction;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class Index extends Controller
{
    public static function keyWallet()
    {
        $id = Auth::user()->id;
        $adressPay = User::where('id', $id)->value('adress_pay');
        if ($adressPay === null) {
            $http = Http::get("https://block.io/api/v2/get_new_address/?api_key=f8df-34a2-cc8b-2b22&label=" . $id);
            if ($http['status'] === 'fail') {
                $http = Http::get("https://block.io/api/v2/get_address_balance/?api_key=f8df-34a2-cc8b-2b22&labels=" . $id);
                return User::where('id', Auth::id())->update(['adress_pay' => $http['data']['balances'][0]['address']]);
            }
            return $http['data'];
            if ($http['status'] === 'success') {
                return User::where('id', Auth::id())->update(['adress_pay' => $http['data'][0]['address']]);
            }
        }
    }

    public function load()
    {
        return Transaction::responceAll();
    }
}