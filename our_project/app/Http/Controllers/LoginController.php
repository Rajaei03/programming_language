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

        $user = User::where('email', $validated['email'])->first();

        if(!$user || !Hash::check($validated['password'], $user->passwprd)){
            return response([
                'message' => 'bad creds'
            ],401);
        }



        $token = $user->createToken('myToken')->plainTextToken;

        $resp = [
            'user' => $user,
            'token' => $token
        ];

        return response($resp,201);


    }
}
