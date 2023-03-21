<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'orders';
    protected $quarded = [];

    protected $fillable =
    [
        'id',
        'user_id',
        'price',
        'status',
        'updated_at',
        'deleted_at',
    ];

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
        )->withTimestamps();
    }
}