<?php

namespace App\Events;

use App\Models\Chirp;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChirpPosted implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $chirp;
    /**
     * Create a new event instance.
     */
    public function __construct(Chirp $chirp)
    {
        $this->chirp = $chirp;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chirps'),
        ];
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->chirp->id,
            'user' => $this->chirp->user->name,
            'message' => $this->chirp->message,
            'created_at' => $this->chirp->created_at->format('j M Y, g:i a'),
        ];
    }
}
