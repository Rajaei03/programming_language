<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{
    public function registerUser(Request $request)
    {
        $fields = $request->validate(
            [
                'name'=>'required|string',
                'email'=>'required|string|unique:users,email',
                'password'=>'required|string|min:6',
                'phone1'=>'required|string',
                'isExp'=>'required'
            ]
            );
            $user = User::create([
                'name'=>$fields['name'],
                'email'=>$fields['email'],
                'password'=>bcrypt($fields['password']),
                'phone1'=>$fields['phone1'],
                'phone2'=>'243423',
                'balance'=>500,
                'isExp'=>$fields['isExp']
            ]);
            $token = $user->createToken('loginToken')->plainTextToken;
            $response = [
                'user'=>$user,
                'token'=>$token
            ];
            return response($response , 201);
    }
    public function index()
    {
        return User::all();
    }
}
