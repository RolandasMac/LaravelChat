<?php
namespace App\Http\Controllers;

use App\Events\MessageEvent;
use App\Models\ChatRoom;
use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function getMessages(ChatRoom $room)
    {
        return response()->json($room->messages()->with('user')->latest()->take(20)->get());
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'chat_room_id' => 'required|exists:chat_rooms,id',
            'message'      => 'required|string|max:255',
        ]);
        $sender     = auth()->id();
        $user       = auth()->user();
        $receiverId = $request->chat_room_id;

        $message = Message::create([
            'user_id'      => $sender,
            'chat_room_id' => $receiverId,
            'message'      => $request->message,
        ]);
        // event(new MessageEvent($message, $sender, $receiverId));
        broadcast(new MessageEvent($message, $sender, $receiverId, $user))->toOthers();

        return response()->json(['message' => 'Žinutė išsiųsta!', 'data' => $message, 'success' => true], 201);
    }
}
