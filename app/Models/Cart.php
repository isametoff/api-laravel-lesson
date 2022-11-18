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
        'products_id',
        'cnt',
        'id',
        'updated_at',
        'deleted_at',
    ];
}
