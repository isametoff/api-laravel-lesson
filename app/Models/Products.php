<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'products';
    protected $quarded = [];

    protected $fillable =
    [
        'id',
        'first_name',
        'middle_name',
        'last_name',
        'sex',
        'dob_year',
        'state',
        'sity',
        'dl',
        'zip',
        'price',
        'updated_at',
        'deleted_at',
    ];

    public static function allProducts()
    {
        $orderIds = Order::where('user_id', auth()->id())->pluck('id')->all();
        $orderProductsIds = OrderProducts::whereIn('order_id', $orderIds)->pluck('products_id')->all();
        return Products::whereNotIn('id', $orderProductsIds);
    }
}
