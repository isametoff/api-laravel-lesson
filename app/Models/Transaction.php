<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'transactions';
    protected $quarded = [];

    protected $fillable =
    [
        'user_id',
        'balance_change',
        'confirmations',
        'txid',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function notification()
    {
        return $this->hasOne(UserNotifications::class);
    }
}
