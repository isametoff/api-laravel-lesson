<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes(['prefix' => 'api', 'middleware' => ['auth:api']]);
        // Log::info('999');
        // if (request()->hasHeader('authorization')) {
        //     Broadcast::routes(['prefix' => 'api', 'middleware' => ['auth:api']]); //is for the api clients requests(React Native App in my case)
        // } else {
        //     Broadcast::routes(); //is for the web requests
        // }
        // Broadcast::routes();
        // Broadcast::routes(['middleware' => ['api', 'jwt.auth']]);
        // Broadcast::channel('App.User.*', function ($user, $userId) {
        //     return (int)$user->user_id === (int)$userId;
        // });
        // Broadcast::routes(['middleware' => 'auth:api']);

        require base_path('routes/channels.php');
    }
}
