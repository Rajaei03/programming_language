<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\User;
use App\Models\Expert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required','string'],
            'password' => ['required','string','min:6']
        ]);


        if(!Auth::attempt($request->only(['email','password']))){
            return response([
                'message' => "bad cred",
                'status' => false,
                'data' => ""
            ],200);
        }

        $user = User::where('email', $validated['email'])->first();
        $token = $user->createToken('loginToken')->plainTextToken;

        if($user->isExp == 0 ){
            $resp = [
                'user' => $user,
                'token' => $token
            ];
            return response()->json([
                'message' => "logged in successfully",
                'status' => true,
                'data' => $resp
            ],201);
        }

        $expert =Expert::where('user_id', $user->id )->first();

        $days = Day::where('user_id',$user->id)->first();

        $experiences = DB::table('experiences')
                            ->where('user_id','=',$user->id)
                            ->get();

        $experienceReady = array();
            foreach ($experiences as $experience){
                $user_Id = $experience->user_id;
                $category_id = $experience->category_id;
                $category = DB::table('categories')
                            ->where('id','=',$experience->category_id)
                            ->first();
                $category_name = $category->name;
                $price = $experience->price;

                $packet = [
                    'user_id' => $user_Id,
                    'category_id' => $category_id,
                    'category_name' => $category_name,
                    'price' => $price,
                ];
                $experienceReady[] = $packet;
            }

        $durations = DB::table('durations')
                        ->where('user_id','=',$user->id)
                        ->get();


        $response = [

                'expertInfo' => $expert,
                'days' => $days,
                'experiences' => $experienceReady,
                'duration' => $durations,
            ];

            $expertGo = [
                'user' => $user,
                'expert' => $response,
                'token'=>$token

            ];




        return response()->json([
            'message' => "logged in successfully",
            'status' => true,
            'data' => $expertGo
        ],201);


    }


    public function logout()
    {
        /** @var Illuminate\Support\Facades\Auth **/
        Auth::user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => "Successfully logged out"
        ]);
    }
}
