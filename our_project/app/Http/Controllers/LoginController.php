<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required','string','email'],
            'password' => ['required','string','min:6']
        ]);


        if(!Auth::attempt($request->only(['email','password']))){
            return response([
                'message' => "bad cred"
            ],401);
        }

         $user = User::where('email', $validated['email'])->first();



        



        $token = $user->createToken('loginToken')->plainTextToken;

        $resp = [
            'user' => $user,
            'token' => $token
        ];

        return response($resp,201);


    }
}
