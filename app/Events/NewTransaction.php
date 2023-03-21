<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NewTransaction implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $channelKey;
    private $valueName;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($channelKey, $valueName)
    {
        $this->channelKey = $channelKey;
        $this->valueName = $valueName;
    }
    public function broadcastWith()
    {
        return [$this->valueName => true];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\PrivateChannel
     */
    public function broadcastOn()
    {
        // Log::info(new PrivateChannel('channel.' . $this->channelKey));
        return new PrivateChannel('channel.' . $this->channelKey);
    }

    // public function broadcastQueue()
    // {
    //     return 'default';
    // }
}
