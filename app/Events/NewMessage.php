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
//https://www.youtube.com/watch?v=rNOGLLPXzwc
class NewMessage implements ShouldBroadcast
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
        //return new PrivateChannel('home');
        return new Channel('home');
    }

    public function broadcastAs()
    {
        return 'message-data';
    }

    public function broadcastWith()
    {
        /*return [
            'message' => $this->message,
        ];*/
        //return response()->json(['data' => $this->message]);
        //return response()->json(['data' => $this->message]);
        return [
            'data' => $this->message,
        ];
    }
}
