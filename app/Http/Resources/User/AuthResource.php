<?php

namespace App\Http\Resources\User;

use App\Actions\Index;
use App\Actions\Orders\Index as OrdersIndex;
use App\Actions\Statistics;
use App\Models\Order;
use App\Models\OrderProducts;
use App\Models\Transaction;
use App\Models\UserActiviness;
use App\Models\UserPasswords;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'login' => $this->login,
            'email' => $this->email,
            'adress_pay' => $this->adress_pay,
            'balance' => $this->balance,
            'admin' => $this->role === 10 ? true : false,
            'privatChannel' => base64_encode(now()->format('Y-m-d e') . $this->updated_at),
            'balance_info' => [
                'amount_of_deposits' => array_sum(
                    Transaction::where('user_id', auth()->id())->where('confirmations', 1)->pluck('balance_change')->all()
                ),
                'total_of_all_orders' => array_sum(
                    Order::where('user_id', auth()->id())->pluck('price')->all()
                ),
                'count_orders' => Order::where('user_id', auth()->id())->count('price')
            ],
            'activiness' =>
            ActivinessResource::collection(
                UserActiviness::where('user_id', auth()->id())->orderBy('created_at', 'DESC')->paginate(10)
            ),
            'last_password_update' =>
            UserPasswords::where('user_id', auth()->id())->exists() ?
                date('M j, Y', strtotime(UserPasswords::where('user_id', auth()->id())->orderBy('created_at', 'DESC')->value('created_at'))) : '',
        ];
    }
}
