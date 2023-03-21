<?php

namespace App\Jobs;

use App\Events\NewBalance;
use App\Models\User;
use App\Models\UserNotifications;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Throwable;

class NewBalanceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $twoKey = (User::where('adress_pay', $this->request['data']['address'])->value('updated_at'));
        $userId = User::where('adress_pay', $this->request['data']['address'])->value('id');
        UserNotifications::create([
            'user_id' => $userId,
            'message' => 'Your balance is topped up',
        ]);
        // Log::info($this->request['data']['address']);
        // NewBalance::dispatch(base64_encode(now()->format('Y-m-d e') . $twoKey), 'balance');
        broadcast((new NewBalance(base64_encode(now()->format('Y-m-d e') . $twoKey), 'balance')));
    }

    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(Throwable $exception)
    {
        $twoKey = (User::where('adress_pay', $this->request['data']['address'])->value('updated_at'));
        $userId = User::where('adress_pay', $this->request['data']['address'])->value('id');
        UserNotifications::create([
            'user_id' => $userId,
            'message' => 'Your balance is topped up',
        ]);
        // Log::info($this->request['data']['address']);
        // NewBalance::dispatch(base64_encode(now()->format('Y-m-d e') . $twoKey), 'balance');
        broadcast((new NewBalance(base64_encode(now()->format('Y-m-d e') . $twoKey), 'balance')));
    }
}