<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatRoomMember extends Model
{
    use HasFactory;
    

    protected $fillable = [
        'chat_room_id',
        'user_id',
        'is_admin',
    ];

    
    public function chatRoom(): BelongsTo
    {
        return $this
            ->belongsTo(ChatRoom::class);
    }

    
    public function user(): BelongsTo
    {
        return $this
            ->belongsTo(User::class);
    }
}
