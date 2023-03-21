<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'posts';
    protected $quarded = [];

    protected $fillable =
    [
        'user_id',
        'title',
        'body',
        'status',
        'fix',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
