<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProducts extends Model
{
    use HasFactory;

    protected $table = 'order_products';
    protected $quarded = [];

    protected $fillable =
    [
        'id',
        'order_id',
        'product_id',
        'product_count',
        'remember_token',
    ];

    // public function orders()
    // {
    //     return $this->belongsToMany(Order::class);
    // }
}
