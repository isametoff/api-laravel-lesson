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
        'updated_at',
        'deleted_at',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function products()
    {
        return $this->belongsTo(Products::class);
    }
}
