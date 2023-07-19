<?php

namespace App\Http\Controllers\API;

use App\Events\MessageCreated;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChatRoom;

class ChatRoomController extends Controller
{
    
    public function testEvent() {
        MessageCreated::dispatch('test');
        return response()->json('Sent');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    public function index()
    {
        try {
            // Get all rooms
            $rooms = ChatRoom::all();

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
    public function create()
    {}

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
                'name' => $request->input('name')
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
            $room = ChatRoom::find($id);

            if (!$room) {
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
