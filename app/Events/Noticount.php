<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Noticount implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $unread;

    public function __construct($userId, $unread)
    {
        $this->userId = $userId;
        $this->unread = $unread;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('private-user.'.$this->userId);
    }

    public function broadcastAs(): string
    {
        return 'NoticountEvent';
    }

    // public function broadcastWith(): array
    // {
    //     return [
    //         'unread' => $this->unread
    //     ];
    // }
}
