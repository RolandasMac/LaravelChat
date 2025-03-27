<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'chat_room_user')
            ->using(ChatRoomUser::class)        // Nurodome Pivot modelį
            ->withPivot(['role', 'joined_at']); // Jei yra papildomi laukai
    }
}
