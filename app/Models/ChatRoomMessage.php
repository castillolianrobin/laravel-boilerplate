<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoomMessage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'message',
        'room_id',
        'sender_id',
    ];

    public function room() {
        return $this->hasOne('App\Models\ChatRoom', 'id', 'room_id');
    }

    public function user() {
        return $this->hasOne('App\Models\User', 'id', 'sender_id');
    }
}
