<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'orders';
    protected $quarded = false;

    protected $fillable =
    [
        'id',
        'user_id',
        'products',
        'count',
        'status',
        'remember_token',
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
            Tag::class,
            'order_products',
            'user_id',
            'product_id',
            'product_count',
        );
    }
}