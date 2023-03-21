<?php

namespace App\Actions;

use App\Models\UserNotifications;

class Notification
{
    public function index()
    {
    }

    public static function newNotificationTransaction(int $userId, string $transactionId, string $status)
    {
        return UserNotifications::create([
            'user_id' => $userId,
            'transaction_id' => $transactionId,
            'status' => $status,
        ]);
    }
}
