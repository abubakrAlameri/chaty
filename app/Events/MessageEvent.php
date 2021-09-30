<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $user; 
    public $currentConversation; 
    public $message; 
    public $is_read; 
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user , $currentConversation, $message , $is_read)
    {
     
        $this->currentConversation = $currentConversation;
        $this->message = $message;
        $this->user = $user;
        $this->is_read = $is_read;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chat.'.$this->currentConversation);
    }

    public function broadcastAs()
    {
        return 'messages';
    }
}
