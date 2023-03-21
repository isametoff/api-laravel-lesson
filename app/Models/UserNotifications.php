<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotifications extends Model
{
    use HasFactory;

    protected $table = 'user_notifications';
    protected $quarded = [];

    protected $fillable =
    [
        'user_id',
        'transaction_id',
        'status',
        'created_at',
        'updated_at',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
