<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NewOrder implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    private $orderData;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(array $orderData)
    {
        $this->orderData = $orderData;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('order.'.$this->orderData['id_seller']);
    }

    public function broadcastAs() // якщо цього метода немє, то назва береться із назви класа - NewOrder
    {
        return 'send.order.data'; // event
    }

    public function broadcastWith()
    {
        Log::debug("broadcastWith", [$this->orderData]);
        return [ //data send to chanel
            'order_data' => $this->orderData,
            'custom' => 1,
        ];
    }
}
