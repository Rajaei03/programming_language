<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\Experience;
use App\Models\User;
use App\Models\Expert;
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
            return response()->json(
                [
                    'status' => 'rigestered successful',
                    'data' => $response
                ]
            ,201 );
    }

    public function index()
    {
        return User::all();
    }


    public function registerExpert(Request $request)
    {
        $fields = $request->validate(
            [
                'name'=>'required|string',
                'email'=>'required|string|unique:users,email',
                'password'=>'required|string|min:6',
                'phone1'=>'required|string',
                'isExp'=>'required',
                'country' => 'required',
                'city' => 'required',
                'skills' => 'required',
                'categories' => 'required',
                'days' => 'required',
                'durations' => 'required'
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


            $expert = Expert::create([
                'user_id'=> $user->id,
                'country'=>$fields['country'],
                'city'=>$fields['city'],
                'skills'=>$fields['skills']
            ]);

            $WorksDays = $fields['days'];

            $days = Day::create([
                'sunday' => $WorksDays[0],
                'monday' => $WorksDays[1],
                'tuesday' => $WorksDays[2],
                'wednesday' => $WorksDays[3],
                'thursday' => $WorksDays[4],
                'friday' => $WorksDays[5],
                'saturday' => $WorksDays[6]
            ]);

            $userCats = $fields['categories'];
            $experiences = [];
            for($i=0;$i<sizeof($userCats);$i++){
                if($userCats[$i]->id<=5){
                    $experiences[$i] = Experience::create([
                        'user_id' => $user->id,
                        'category_id' => $userCats[$i]->id,
                        'price' => $userCats[$i]->price,
                        
                    ]);
                }
            }


    }
}
