<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserActiviness extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_activiness';
    protected $quarded = [];

    protected $fillable =
    [
        'user_id',
        'browser',
        'ip',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
