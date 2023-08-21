<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\UserDetails;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($userID)
    {
        try {
            $userDetails = UserDetails::where('user_id', '=', $userID)->first();
            return ApiResponse::success('User details successfully fetched', $userDetails);
        } catch (Exception $e) {
            return ApiResponse::serverError($e);
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
    public function store(Request $request)
    {
        //
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
        $inputs =  $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_name' => 'nullable',
            'color' => 'nullable',
            'profile_img' => 'nullable|image',
        ]);

        try
        {
            $userDetails= UserDetails::find($id);
            // Store Basic Details
            $userDetails->first_name = $inputs['first_name'];
            $userDetails->last_name = $inputs['last_name'];
            $userDetails->middle_name = $inputs['middle_name'] ?? null;
            $userDetails->color = $inputs['color'] ?? null;
            // Store Image
            $profileImg = $request->file('profile_img');
            if ($profileImg->isValid()) {
                echo 'File';
                $filePath = $profileImg->store('/users/'.$userDetails->user_id.'/profile-img');
                $userDetails->profile_img_url = Storage::url($filePath);
            }

            $userDetails->save();

            return ApiResponse::success('Profile successfully saved', $userDetails);
        }   
        catch (\Exception $e)
        {
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
        //
    }
}
