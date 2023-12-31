<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            // Create user
            $user = User::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'color' => $request->input('color'),
            ]);

            // If user is not created
            if (!$user) {
                return ApiResponse::noContent(config('constants.REGISTRATION_UNSUCCESSFUL'));
            }

            // Create token
            $token = $user->createToken('user_token')->plainTextToken;

            return ApiResponse::created(
                config('constants.REGISTRATION_SUCCESSFUL'),
                [
                    'user' => $user,
                    'token' => $token
                ]
            );
        }
        catch (\Exception $e) {
            return ApiResponse::serverError($e->getMessage());
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            // Find user
            $user = User::with('userDetails')->where('email', '=', $request->input('email'))->first();
            
            // If user doesn't exist
            if (!$user) {
                return ApiResponse::unauthorized(config('constants.USER_NOT_FOUND'));
            }

            // If password is correct
            if (Hash::check($request->input('password'), $user->password)) {
                // Create token
                $token = $user->createToken('user_token')->plainTextToken;
    
                return ApiResponse::success(
                    config('constants.LOGIN_SUCCESSFUL'),
                    [
                        'user' => $user,
                        'token' => $token
                    ]
                );
            }

            return ApiResponse::unauthorized(config('constants.LOGIN_UNSUCCESSFUL'));
        }
        catch (\Exception $e) {
            return ApiResponse::serverError($e->getMessage());
        }
    }

    public function logout()
    {
        try {
            $user = User::findOrFail(Auth::id());
    
            $deleteUser = $user->tokens()->delete();

            if (!$deleteUser) {
                return ApiResponse::noContent(config('constants.LOGOUT_UNSUCCESSFUL'));
            }
    
            return ApiResponse::success(config('constants.LOGOUT_SUCCESSFUL'));
        }
        catch (\Exception $e) {
            return ApiResponse::serverError($e->getMessage());
        }
    }
}
