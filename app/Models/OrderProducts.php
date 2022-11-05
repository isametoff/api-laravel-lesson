<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProducts extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'order_products';
    protected $quarded = false;

    protected $fillable =
    [
        'id',
        'user_id',
        'product_id',
        'product_count',
    ];


}
