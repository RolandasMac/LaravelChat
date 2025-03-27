<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ChatRoomUser extends Pivot
{
    use HasFactory;

    protected $table = 'chat_room_user'; // Nurodome, kad tai tarpinė lentelė

    protected $fillable = ['chat_room_id', 'user_id', 'role', 'joined_at', 'left_at'];

    public $timestamps = false; // Jei lentelėje nėra `created_at` ir `updated_at`, išjungiame timestamps

    public function chatRoom()
    {
        return $this->belongsTo(ChatRoom::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
