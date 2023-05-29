<?php

namespace App\Events;

use App\Models\User;
use App\Models\Message;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Message $message;

    public User $user;

    /**
     * Create a new event instance.
     */
    public function __construct(Message $message) {
        $this->message = $message;
        $this->user = $message->user;
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,
            'text' => $this->message->text,
            'sent_at' => $this->message->created_at->diffForHumans(),
            'user' => [
                'username' => $this->user->username,
            ]
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\PrivateChannel>
     */
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('servers.'.$this->message->server_id.'.channels.'.$this->message->channel_id);
    }
}
