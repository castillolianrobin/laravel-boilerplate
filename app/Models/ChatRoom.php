<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ChatRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_private'
    ];

    public function members(): BelongsToMany
    {
        return $this
            ->belongsToMany(User::class, 'chat_room_members')
            ->withPivot(['is_admin'])
            ->as('chat_room_members');
    }

    public function messages()
    {
        return $this
            ->hasMany('App\Models\ChatRoomMessage');
    }
}
