<?php

namespace App\Jobs;

use App\Actions\Orders\Index;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;

class OrderAfterCreateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Index $orders)
    {
        $userId = $this->data['userId'];
        $orderId = $this->data['orderId'];
        $orderReserve = $orders->orderReserve($userId, $orderId);

        Log::info($orderReserve);
    }

    // public function failed()
    // {
    //      Отправляем пользователю уведомление об ошибке и т.д.
    // }
}
