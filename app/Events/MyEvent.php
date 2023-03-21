<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Support\Facades\Log;

class MyEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $channelKey;
    private $valueName;
    private $data;


    public function __construct($channelKey, $valueName, $data)
    {
        $this->channelKey = $channelKey;
        $this->valueName = $valueName;
        $this->data = $data;
    }

    public function broadcastWith()
    {
        return [$this->valueName => true, 'data' => $this->data];
    }

    public function broadcastOn()

    {
        // Log::info(
        //     [
        //         $this->channelKey,
        //         $this->valueName,
        //         $this->data
        //     ]
        // );

        return [$this->channelKey];
    }

    public function broadcastAs()
    {
        return 'my-event';
    }
}
