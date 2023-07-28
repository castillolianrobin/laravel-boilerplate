<?php

use App\Models\ChatRoom;
use App\Models\ChatRoomMember;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


/** Authenticate room membership */
Broadcast::channel('room.{room}', function ($user, $room) {
    $roomMembership = ChatRoomMember::where([
        ['user_id', '=', $user->id],
        ['chat_room_id', '=', $room],
    ])->first();
    
    Log::debug('pusher test.', [
        'user'=>$user,
        'membership'=>$roomMembership
    ]);
    
    if ($roomMembership) {
        return $user;
    } else {
        $room = ChatRoom::find($room);
        return $room->is_private ? null : $user;
    }
});