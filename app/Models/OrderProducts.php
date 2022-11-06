<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderProducts extends Pivot
{
    use HasFactory;

    protected $table = 'order_products';
    protected $quarded = false;

    protected $fillable =
    [
        'id',
        'order_id',
        'product_id',
        'product_count',
        'remember_token',
    ];


}