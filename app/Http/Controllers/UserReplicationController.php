<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserReplicationController extends Controller
{
    public function replicate() {
        $users = User::all();

        $users = DB::table('users')
            ->select('id', 'first_name', 'last_name', 'color')
            ->get();

        foreach ($users as $user) {
            $userDetailExists = UserDetails::where('user_id', '=', $user->id)->first();

            if ($userDetailExists) {
                echo "User already replicated: " . $user->id . "<br>";
                continue;
            }

            $userDetail = UserDetails::create([
                'user_id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'color' => $user->color,
            ]);
            echo "Replicating user: " . $user->id . "<br>";

            if (!$userDetail) {
                echo "Replication unsucessful." . "<br>";
            }
            else {
                echo "Replicated user detail: " . $userDetail->id . "<br>";
            }
        }
    }
}
