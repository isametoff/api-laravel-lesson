<?php

namespace App\Actions;

use App\Events\MyEvent;
use App\Http\Resources\BalanceResource;
use App\Models\Transaction as ModelsTransaction;
use App\Models\User;
use App\Models\UserNotifications;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Transaction
{
    public static function index($request)
    {
        // Log::info($request['data']['balance_change'] > 0);
        if ($request['data'] && $request['data']['balance_change'] > 0) {
            $request = $request['data'];
            $confirmations = $request['confirmations'];
            $oneBtc = Http::get("https://min-api.cryptocompare.com/data/price?fsym=USD&tsyms=BTC")['BTC'];
            $amount = ($request['balance_change'] - "0.00002") / $oneBtc;
            $twoKey = User::where('adress_pay', $request['address'])->value('updated_at');
            $userId = User::where('adress_pay', $request['address'])->value('id');
            $transaction = ModelsTransaction::where('txid', $request['txid'])->where('user_id', $userId);
            Log::info($request);

            if ($confirmations === 1 || $confirmations === 0) {
                if ($userId && $oneBtc) {
                    if ($confirmations === 0 && $transaction->doesntExist()) {
                        Transaction::newTransaction($request, $userId, $amount);
                    } elseif ($confirmations === 1 && $transaction->doesntExist()) {
                        Transaction::balanceUpdate($userId, $amount);
                        Transaction::newTransaction($request, $userId, $amount);
                    } elseif ($confirmations === 1 && $transaction->where('confirmations', 0)->exists()) {
                        Transaction::balanceUpdate($userId, $amount);
                        $transaction->update(
                            [
                                'confirmations' => $confirmations
                            ],
                        );
                    }
                    $transaction = ModelsTransaction::where('txid', $request['txid'])->where('user_id', $userId);
                    if (
                        $transaction->value('id') &&
                        UserNotifications::where('transaction_id', $transaction->value('id'))
                        ->where('user_id', $userId)
                        ->where('status', $confirmations)->doesntExist()
                    ) {
                        // Log::info($transaction->value('id'));
                        Notification::newNotificationTransaction(
                            $userId,
                            $transaction->value('id'),
                            $confirmations
                        );
                        broadcast(new MyEvent(base64_encode(now()->format('Y-m-d e') . $twoKey), 'balance', $transaction->first()));
                    } else {
                        return false;
                    }
                };
            }
        }
    }

    public static function newTransaction(array $request, int $userId, $amount)
    {

        return ModelsTransaction::updateOrCreate(
            [
                'user_id' => $userId,
                'balance_change' => $amount,
                'txid' => $request['txid'],
            ],
            [
                'confirmations' => $request['confirmations'],
            ]
        );
    }

    public static function responceAll()
    {
        return BalanceResource::collection(ModelsTransaction::where('user_id', Auth::id())->orderBy('created_at', 'DESC')->get());
    }
    public static function balanceUpdate($userId, $amount)
    {
        User::where('id', $userId)
            ->update(
                ['balance' => User::where('id', $userId)->value('balance') + $amount]
            );
    }
}
