<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::channel('channel.{channelKey}', function () {
    // Log::info(Auth::id());
    // Log::info($user);
    // Log::info(Auth::check());
    //return true if api user is authenticated
    return Auth::check();
    // Log::info((int) $user->id === (int) $id);
    // return (int) $user->id === (int) $id;
});