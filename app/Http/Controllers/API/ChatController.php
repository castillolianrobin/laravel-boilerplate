<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function rooms(Request $request)
    {
        try {
            $rooms = Room::all();

            return response()->json([
                'rooms' => $rooms,
            ], 200);
        }
        catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Something went wrong in ChatController.rooms'
            ]);
        }
    }

    public function messages(Request $request, $roomId)
    {
        try {
            $messages = Message::where('room_id', $roomId)
            ->with('user')
            ->orderBy('created_at', 'DESC')
            ->get();
    
            return response()->json([
                'messages' => $messages,
            ], 200);
        }
        catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Something went wrong in ChatController.messages'
            ]);
        }
    }

    public function newMessage(Request $request, $roomId)
    {
        try {
            $message = Message::create([
                'sender_id' => Auth::id(),
                'room_id' => $roomId,
                'message' => $request->message,
            ]);
    
            return response()->json([
                'message' => $message,
            ], 200);
        }
        catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Something went wrong in ChatController.newMessage'
            ]);
        }
    }
}
