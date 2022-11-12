<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\Post\Status;
use App\Casts\Base64Json;

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
        'remember_token',
        'updated_at',
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
            'id',
        );
    }
}
