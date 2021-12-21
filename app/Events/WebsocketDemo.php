<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WebsocketDemo implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $aux;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($aux)
    {
        $this->aux = $aux;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('DemoChannel');
    }
}
