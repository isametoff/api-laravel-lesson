<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Casts\Base64Json;
use App\Enums\Order\Status;
use App\Jobs\OrderAfterCheckingJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'orders';
    protected $quarded = [];

    protected $fillable =
    [
        'id',
        'user_id',
        'count',
        'status',
        'updated_at',
        'deleted_at',
    ];
    // protected $casts = [
    //     'status' => Status::class,
    //     'options' => Base64Json::class
    // ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function products()
    {
        return $this->belongsToMany(
            Products::class,
            'order_products',
            'order_id',
            'products_id',
        )->withPivot('product_count',)->withTimestamps();
    }
    public static  function totalPrice($userId)
    {
        $total = 0;
        $order = Order::where('user_id', Auth::user()->id)->where('id', $userId);
        $orderItem = $order->with('products')->first();
        foreach ($orderItem->products as $product) {
            $price = $product->pivot->product_count * $product->price;
            $total += $price;
        }
        return $total;
    }
    public function orderProducts($orderId)
    {
        $ordersUser = Order::where('user_id', Auth::user()->id)->where('id', $orderId);
        $ordersProducts = $ordersUser->with('products')->get();
        // dd(Auth::user()->id);
        return $ordersProducts;
    }
    public function ordersProducts()
    {
        $ordersUser = Order::where('user_id', Auth::user()->id);
        $ordersProducts = $ordersUser->with('products')->get();
        return $ordersProducts;
    }
    public function orderDelete($userId, $orderId)
    {
        $ordersUserExist = Order::where('user_id', $userId)->where('id', $orderId)
            ->exists();
        Order::where('user_id', $userId)->where('id', $orderId)->delete();
        OrderProducts::where('order_id', $orderId)->delete();
        $message = $ordersUserExist ? Order::where('user_id', $userId)
            ->where('id', $orderId)->doesntExist()
            ? 'Успешно удалён' : 'Ошибка при удалении' : 'Товар уже удалён';
        return $message;
    }
    public function orderReserve($userId, $orderId)
    {
        $ordersUser = Order::where('user_id', $userId)->where('id', $orderId);
        $orderProducts = $ordersUser->with('products')->first();
        $waiting = get_object_vars(Status::WAITING);

        if ($ordersUser->first()->status === $waiting['value']) {
            OrderAfterCheckingJob::dispatch(compact('orderId', 'userId'))->delay(now()->addSeconds(10));
        }
    }
    public function orderCanceled($userId, $orderId)
    {
        $ordersUser = Order::where('user_id', $userId)->where('id', $orderId);
        $orderProducts = $ordersUser->with('products')->first();
        $waiting = get_object_vars(Status::WAITING);
        $canceled = get_object_vars(Status::CANCELED);


        if ($ordersUser->first()->status === $waiting['value']) {
            foreach ($orderProducts->products as $product) {
                $rest = Products::where('id', $product->pivot->products_id)->value('rest');
                Products::where('id', $product->pivot->products_id)
                    ->update([
                        'rest' => $rest + $product->pivot->product_count,
                    ]);
            }
            $this->orderDelete($userId, $orderId);
        } elseif ($ordersUser->first()->status === $canceled['value']) {
            foreach ($orderProducts->products as $product) {
                $rest = Products::where('id', $product->pivot->products_id)->value('rest');
                Products::where('id', $product->pivot->products_id)
                    ->update([
                        'rest' => $rest + $product->pivot->product_count,
                    ]);
            }
        }
    }
}