<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Helpers\ApiResponse;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Nette\Utils\Image;

class SettingsController extends Controller
{
    public function updateProfile(Request $request)
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
            $userId = Auth::id();
            $userDetails= UserDetails::where('user_id', '=', $userId)->first();
            // Store Basic Details
            $userDetails->first_name = $inputs['first_name'];
            $userDetails->last_name = $inputs['last_name'];
            $userDetails->middle_name = $inputs['middle_name'] ?? null;
            $userDetails->color = $inputs['color'] ?? null;
            // Store Image
            $profileImg = $inputs['profile_img'];
            if ($profileImg && $profileImg->isValid()) {
                $filePath = $profileImg->store('/users/'.$userId.'/profile-img');
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
}
