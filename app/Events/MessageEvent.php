<?php
namespace App\Events;

use Date;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Log;

class MessageEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $sender;
    public $receiverId;

    public $user;
    /**
     * Create a new event instance.
     */
    public function __construct($message, $sender, $receiverId, $user)
    {
        $this->message    = $message;
        $this->sender     = $sender;
        $this->receiverId = $receiverId;
        $this->user       = $user;
        Log::info('MessageEvent sukurtas su žinute: ', [$message, $receiverId, $user]);

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    //broadcastOn metodas nurodo kanalą, per kurį bus išsiųsti įvykiai. Jūs naudojate bendrą kanalą "chat".
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.' . $this->receiverId), // Tik gavėjo kanalas,
                                                             // new Channel("chat"),
        ];
    }
    // broadcastAs metodas nurodo įvykio pavadinimą, kuris bus naudojamas front-end pusėje. Jūs nustatėte 'send-message'.
    public function broadcastAs(): string
    {
        return 'send-message';
    }
    // broadcastWith metodas nurodo duomenis, kurie bus siunčiami kartu su įvykiu. Šiuo atveju tai pranešimas.
    public function broadcastWith(): array
    {
        $this->message->load('user');
        // $this->message->userName = $this->user->name;
        $this->message->datetime = Date::now();
        return [
            'message' => $this->message->toArray(),
        ];
    }

}
