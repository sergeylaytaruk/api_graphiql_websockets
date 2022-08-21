<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Laravel\Sail\Console\PublishCommand;
use Illuminate\Support\Facades\Log;

class NewBroadcast implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        //return new PrivateChannel('channel-name');
//        return new Channel('chanel'); // name chanel
        // підписати наприклад "order.".$seler_id
        return new Channel('SendMessageChanel'); // name chanel
    }

    public function broadcastAs()
    {
        return 'SendMessageChanel-data'; // event
    }

    public function broadcastWith()
    {
        Log::debug("broadcastWith", [$this->message]);
        return [ //data send to chanel
            'message' => $this->message,
            'custom' => 1,
        ];
    }
}
