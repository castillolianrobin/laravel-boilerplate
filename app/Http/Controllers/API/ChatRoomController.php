<?php

namespace App\Http\Controllers\API;

use App\Events\MessageCreated;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatRoom;
use App\Models\ChatRoomMembers;
use Illuminate\Support\Facades\Auth;

class ChatRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    public function index()
    {
        try {
            $userId = Auth::id();
            $privateRoomId = ChatRoomMembers::
                where('user_id', $userId)
                ->pluck('chat_room_id')
                ->toArray();
            
            // Fetch chat rooms
            $rooms = ChatRoom::
                withCount('members')
                ->where('is_private', 0)
                ->orWhereIn('id', $privateRoomId)
                ->get();
            
            // If no rooms found
            if (!count($rooms)) {
                return ApiResponse::noContent(config('constants.CHAT_ROOMS_EMPTY'));
            }

            return ApiResponse::success(null, $rooms);
        }
        catch (\Exception $e) {
            return ApiResponse::serverError($e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create() {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $room = ChatRoom::create([
                'name' => $request->input('name'),
                'is_private' => (bool) $request->input('is_private') ?? false,
            ]);

            $user = Auth::user();
            
            // Creator as admin
            ChatRoomMembers::create([
                'user_id' => $user->id,
                'chat_room_id' => $room->id,
                'is_admin' => true,
            ]);

            return ApiResponse::success('New room created!', $room);
        }
        catch (\Exception $e) {
            return ApiResponse::serverError($e->getMessage());
        }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $room = ChatRoom::with('members')->find($id);
            $forbidden = false;
            
            if ($room->is_private) {
                $members = $room->members()->find((integer) Auth::id());
                $forbidden = is_null($members);
            }
            
            if (!$room || $forbidden) {
                return ApiResponse::noContent();
            }


            return ApiResponse::success(null, $room);
        }
        catch (\Exception $e) {
            return ApiResponse::serverError($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $room = ChatRoom::find($id);
            $room->name = $request->input('name') ?? $room->name;
            $room->save();
            
            return ApiResponse::success('Room updated successfully', $room);
        } 
        catch (\Exception $e) {
            return ApiResponse::serverError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $room = ChatRoom::find($id);
            $room->delete();
            return ApiResponse::success('Room deleted successfully.', $room);
        } 
        catch (\Exception $e) {
            return ApiResponse::serverError($e->getMessage());
        }
    }
}
