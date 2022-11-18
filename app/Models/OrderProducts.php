<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProducts extends Pivot
{
    use HasFactory, SoftDeletes;

    protected $table = 'order_products';
    protected $quarded = [];

    protected $fillable =
    [
        'id',
        'order_id',
        'products_id',
        'product_count',
        'updated_at',
        'deleted_at',
    ];

    // public function orders()
    // {
    //     return $this->belongsToMany(Order::class);
    // }
}