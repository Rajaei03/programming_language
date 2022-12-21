<?php

namespace App\Http\Controllers;

use App\Models\Expert;
use App\Models\User;
use Illuminate\Http\Request;
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
                'message' => "bad cred"
            ],401);
        }

        $user = User::where('email', $validated['email'])->first();
        $expert =Expert::where('user_id', $user->id )->first();






        $token = $user->createToken('loginToken')->plainTextToken;

        $resp = [
            'user' => $user,
            'expert' => $expert,
            'token' => $token
        ];

        return response()->json([
            'message' => "logged in successfully",
            'status' => true,
            'data' => $resp
        ],201);


    }


    public function logout()
    {
        //
    }
}
