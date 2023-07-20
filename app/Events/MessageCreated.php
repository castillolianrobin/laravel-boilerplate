<?php

namespace App\Events;

use App\Models\ChatRoom;
use App\Models\ChatRoomMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Ramsey\Uuid\Type\Integer;

class MessageCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    // New Message to be broadcast
    public $message;
    // Room Channel ID
    public $roomId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ChatRoomMessage $message)
    {
        $this->message = $message;
        $this->roomId = $message->room_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('room.'.$this->roomId);
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'MessageCreated';
    }
}
