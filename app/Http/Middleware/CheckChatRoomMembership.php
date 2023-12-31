<?php

namespace App\Http\Middleware;

use App\Helpers\ApiResponse;
use App\Models\ChatRoom;
use App\Models\ChatRoomMember;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckChatRoomMembership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $role = 'member')
    {
        $roomId = $request->route()->parameter('room');
        if (!is_null($roomId)) {
            // If not member
            $membership = $this->isRoomMember($roomId);
            if (is_null($membership)) {
                return ApiResponse::forbidden('You are not a member of this chat room');
            }
            
            // If admin restricted
            $adminRestrictedActions = ['PUT', 'DELETE', 'POST', 'PATCH'];
            $requestAction = $request->method();
            if ($role === 'admin' && !$membership === 'admin' && in_array($requestAction, $adminRestrictedActions)) {
                return ApiResponse::forbidden('You do not have enough permission to perform this action');
            }
        }

        return $next($request);
    }


    
    /**
     * Check if logged in user has membership rights to the room
     *
     * @param int $roomId
     * @return 'admin' | 'member' | null
     */
    public function isRoomMember($roomId) {
        $roomMembership = ChatRoomMember::where([
            ['user_id', '=', Auth::id()],
            ['chat_room_id', '=', $roomId],
        ])->first();
        
        if ($roomMembership) {
            return $roomMembership->is_admin ? 'admin' : 'member';
        } else {
            $room = ChatRoom::find($roomId);
            return $room->is_private ? null : 'member';
        }
    }
}
