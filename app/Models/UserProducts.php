<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProducts extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_products';
    protected $quarded = [];

    protected $fillable =
    [
        'user_id',
        'product_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
