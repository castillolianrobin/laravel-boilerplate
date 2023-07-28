<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\ChatRoomMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatRoomMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // ApiResponse::success('Test', []);
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
            $email = $request->input('email');
            $user = User::where('email', $email)->first();
            $error = null;

            // If no user
            if (is_null($user)) {
                $error = 'User does not exists';
            }
            // If already a member
            else {
                $existingMember = ChatRoomMember::
                    where([
                        ['user_id', $user->id],
                        ['chat_room_id', $roomId],
                    ])->first();

                if (!is_null($existingMember)) {
                    $error = 'User is already a member';
                }

            }
            
            if ($error) {
                return ApiResponse::error($error, $email);
            }
            
            $member = ChatRoomMember::create([
                'user_id' => $user->id,
                'chat_room_id' => $roomId,
                'is_admin' => $request->input('is_admin') ?? 0,
            ]);

            return ApiResponse::success('Created successfully', $member);

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
        $membership = ChatRoomMember::find($id);
        $membership->delete();
        return ApiResponse::success('Member is no longer available to chat.', $membership);
    }

    /**
     * Remove resource related to logged in user
     */
    public function removeMembership($roomId) {
        $membership = ChatRoomMember::
            where([
                ['user_id', Auth::id()],
                ['chat_room_id', $roomId],
            ])
            ->first();
        
        if(is_null($membership)) {
            return ApiResponse::error('You are not a member of this room');
        }

        return $this->destroy($membership->id);
    }
}
