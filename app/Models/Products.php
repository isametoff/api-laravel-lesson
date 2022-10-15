<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'products';
    protected $quarded = false;

    protected $fillable =
    [
        'id',
        'title',
        'description',
        'content',
        'price',
        'rest',
        'is_published',
        'updated_at',
        'deleted_at',

    ];
}