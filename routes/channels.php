<?php

use App\Models\ChatRoom;
use Illuminate\Support\Facades\Broadcast;

// Broadcast::channel('chat', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

Broadcast::channel('chat.{receiver_id}', function ($user, $receiver_id) {
    // return (int) $user->id === (int) $receiver_id; // Tik tas vartotojas gali gauti žinutę
    $chatRoom = ChatRoom::find($receiver_id);
    if (! $chatRoom) {
        return false; // Jei kambarys neegzistuoja, neleisti prisijungti
    }

    return $chatRoom->users()->where('user_id', $user->id)->exists(); // Tikrina, ar vartotojas priklauso šiam kambariui
});
Broadcast::channel('online', function ($user) {
    // return ['id' => $user->id, 'name' => $user->name];
    return $user->toArray();
});
