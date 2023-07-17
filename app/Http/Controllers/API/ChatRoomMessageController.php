<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatRoomMessage;
use Illuminate\Support\Facades\Auth;

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
            $messages = ChatRoomMessage::where('room_id', $roomId)
            ->with('user')
            ->orderBy('created_at', 'DESC')
            ->get();
    
            return response()->json([
                'chat_room_messages' => $messages,
            ], 200);
        }
        catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Something went wrong in ChatRoomMessageController.index'
            ]);
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
    public function store($roomId, Request $request)
    {
        try {
            $message = ChatRoomMessage::create([
                'sender_id' => Auth::id(),
                'room_id' => $roomId,
                'message' => $request->message,
            ]);
    
            return response()->json($message, 200);
        }
        catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'error_message' => 'Something went wrong in ChatRoomMessageController.store'
            ]);
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
