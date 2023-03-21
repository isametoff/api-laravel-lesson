<?php

namespace App\Actions\Orders;

use App\Models\Order;
use App\Models\OrderProducts;
use App\Models\Products;
use App\Models\User;
use App\Models\UserProducts;
use Illuminate\Support\Facades\Http;

class Store
{
    public function __invoke(array $ids, int $amount)
    {
        $isProduct = true;
        $issetProducts = Products::allProducts()->whereIn('id', $ids)->count() > 0 ? true : false;
        $user = User::where('id', auth()->id());
        $usdToBtc = Http::get("https://min-api.cryptocompare.com/data/price?fsym=USD&tsyms=BTC");
        if ($issetProducts === true) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'price' => $amount,
                'status' => 1,
            ]);
            $user->update(['balance' => $user->value('balance') - $amount]);
            foreach ($ids as $val) {
                OrderProducts::create([
                    'order_id' => $order->id,
                    'products_id' => $val,
                ]);
                UserProducts::create([
                    'user_id' => auth()->id(),
                    'product_id' => $val,
                ]);
            }
        }
        $issetOrderProducts = OrderProducts::where('order_id', $order->id)->count() ===  count($ids) ? true : false;
        $isOrdered = $issetProducts === true && $issetOrderProducts === true ? true : false;
        return compact('isProduct', 'isOrdered', 'issetOrderProducts');
    }
}
