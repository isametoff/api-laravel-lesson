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
    public static function orderProducts($orderId)
    {
        $ordersUser = Order::where('user_id', Auth::user()->id)->where('id', $orderId);
        $ordersProducts = $ordersUser->with('products')->get();
        // dd($ordersProducts);
        return $ordersProducts;
    }
    public function ordersProducts()
    {
        $ordersUser = Order::where('user_id', Auth::user()->id)->where('status', '!=', Status::ADDED);
        $ordersProducts = $ordersUser->with('products')->get();
        return $ordersProducts;
    }
    public static function productsValue($model, $column, $value)
    {
        return $model->where('id', $column)->value($value);
    }
    public function orderReserve($userId, $orderId)
    {
        $ordersUser = Order::where('user_id', $userId)->where('id', $orderId);
        $orderProducts = $ordersUser->with('products')->first();
        $waiting = get_object_vars(Status::WAITING);
        $added = get_object_vars(Status::ADDED);

        if ($ordersUser->first()->status === $added['value']) {
            $this->deleteOrder($userId, $orderId);
        }
        if ($ordersUser->first()->status === $waiting['value']) {
            OrderAfterCheckingJob::dispatch(compact('orderId', 'userId'))->delay(now()->addSeconds(6));
        }
    }
    public function orderCanceled($userId, $orderId)
    {
        $ordersUser = Order::where('user_id', $userId)->where('id', $orderId);
        $orderProducts = $ordersUser->with('products')->first();
        $waiting = get_object_vars(Status::WAITING);
        $canceled = get_object_vars(Status::CANCELED);


        if ($ordersUser->first()->status === $waiting['value']) {
            $this->deleteOrder($userId, $orderId);
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
    public static function returnReservedProduct($userId, $orderId)
    {
        $ordersUser = Order::where('user_id', $userId)->where('id', $orderId);
        $orderProducts = $ordersUser->with('products')->first();

        foreach ($orderProducts->products as $product) {
            $rest = Products::where('id', $product->pivot->products_id)->value('rest');
            Products::where('id', $product->pivot->products_id)
                ->update([
                    'rest' => $rest + $product->pivot->product_count,
                ]);
        }
    }
}