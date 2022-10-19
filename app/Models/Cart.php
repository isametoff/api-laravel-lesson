<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'carts';
    protected $quarded = false;
    protected $dateFormat = 'U';

    protected $fillable =
    [
        'id',
        'product_id',
        'cnt',
        'remember_token',
        'updated_at',
        'deleted_at',
    ];
}
