<?php

namespace App\Http\Controllers\API;

use App\Events\MessageCreated;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatRoomMessage;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Chat\ChatRoomMessageRequest;
use App\Models\ChatRoom;

class ChatRoomMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($roomId)
    {
        try {
            // Get messages
            $messages = ChatRoomMessage::where('room_id', $roomId)
                ->with('user')
                ->orderBy('created_at', 'DESC')
                ->get();

            // If no messages found
            if (!count($messages)) {
                return ApiResponse::noContent(config('constants.CHAT_ROOM_MESSAGES_EMPTY'));
            }
    
            return ApiResponse::success(null, $messages);
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($roomId, ChatRoomMessageRequest $request)
    {
        try {
            // Get room
            $room = ChatRoom::where('id', $roomId)->exists();

            // If room doesn't exist
            if (!$room) {
                return ApiResponse::noContent(config('constants.CHAT_ROOM_NOT_FOUND'));
            }

            $message = ChatRoomMessage::create([
                'sender_id' => Auth::id(),
                'room_id' => (integer) $roomId,
                'message' => $request->message,
            ]);
            

            // If message is not created
            if (!$message) {
                return ApiResponse::noContent(config('constants.CHAT_ROOM_CREATE_MESSAGE_SUCCESSFUL'));
            }
            
            // Emit message created event
            MessageCreated::dispatch($message);
            
            return ApiResponse::created(config(
                'constants.CHAT_ROOM_CREATE_MESSAGE_SUCCESSFUL'),
                $message,
            );
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
