<?php

namespace App\Actions;

use App\Models\User;
use App\Models\UserNotifications;

class Auth
{
    public function role(): bool
    {
        return User::where('id', auth()->id())->value('role') === 10 ? true : false;
    }
}
