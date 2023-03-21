<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPasswords extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_passwords';
    protected $quarded = [];

    protected $fillable =
    [
        'user_id',
        'password',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
