<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Expert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function myProfile()
    {
        $user = Auth::user();
        if($user->isExp==0){
            return response()->json([
                'status' => true,
                'message' => 'done',
                'data' => $user
            ]);
        }

        $expert = DB::table('experts')
                    ->where('user_id','=',$user->id)
                    ->first();

        $days = DB::table('days')
                    ->where('user_id','=',$user->id)
                    ->first();

        $experiences = DB::table('experiences')
                        ->where('user_id','=',$user->id)
                        ->get();

        $durations = DB::table('durations')
                        ->where('user_id','=',$user->id)
                        ->get();

        $response = [

            'expertInfo' => $expert,
            'days' => $days,
            'experiences' => $experiences,
            'duration' => $durations,
        ];

        $expertGo = [
            'user' => $user,
            'expert' => $response,
        ];


        return response()->json([
            'status' => true,
            'message' => 'done',
            'data' => $expertGo
        ]);


    }


    public function profile($id)
    {
        $user = DB::table('users')
                    ->where('id','=',$id)
                    ->first();
        if($user->isExp==0){
            return response()->json([
                'status' => true,
                'message' => 'done',
                'data' => $user
            ]);
        }

        $expert = DB::table('experts')
                    ->where('user_id','=',$user->id)
                    ->first();

        $days = DB::table('days')
                    ->where('user_id','=',$user->id)
                    ->first();

        $experiences = DB::table('experiences')
                        ->where('user_id','=',$user->id)
                        ->get();

        $durations = DB::table('durations')
                        ->where('user_id','=',$user->id)
                        ->get();

        $response = [

            'expertInfo' => $expert,
            'days' => $days,
            'experiences' => $experiences,
            'duration' => $durations,
        ];

        $expertGo = [
            'user' => $user,
            'expert' => $response,
        ];


        return response()->json([
            'status' => true,
            'message' => 'done',
            'data' => $expertGo
        ]);


    }


}
