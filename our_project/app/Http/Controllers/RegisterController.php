<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Day;
use App\Models\User;
use App\Models\Expert;
use App\Models\Category;
use App\Models\Duration;
use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{
    public function registerUser(Request $request)
    {

        try{
            $fields = $request->validate(
            [
                'img'=>'image|required',
                'name'=>'required|string',
                'email'=>'required|string|unique:users,email',
                'password'=>'required|string|min:6',
                'phone1'=>'required|string',
                'isExp'=>'required',
            ]
            );
        }catch(Exception $e){
            return response()->json(
                [
                    'message' => $e->getMessage(),
                    'status' => false,
                    'data' => ""
                ]
            ,200 );
        }
        $input = $request->all();
        if($request->hasFile('img'))
        {
            $filenameToStore = time().'.'.$request->img->extension();
            $request->img->move(public_path('images'),$filenameToStore);
            $input['imgUrl'] = URL::asset('images/'.$filenameToStore);
        }

            $user = User::create([
                'img' => $input['imgUrl'],
                'name'=>$fields['name'],
                'email'=>$fields['email'],
                'password'=>bcrypt($fields['password']),
                'phone1'=>$fields['phone1'],
                'balance'=>500,
                'isExp'=>0
            ]);
            $token = $user->createToken('loginToken')->plainTextToken;
            $response = [
                'user'=>$user,
                'token'=>$token
            ];
            return response()->json(
                [
                    'message' => "registered successfully",
                    'status' => true,
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

            try{
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

            }catch(Exception $e){
                return response()->json(
                    [
                        'message' => $e->getMessage(),
                        'status' => false,
                        'data' => ""
                    ]
                ,200 );
            }



            $user = User::create([
                'name'=>$fields['name'],
                'email'=>$fields['email'],
                'password'=>bcrypt($fields['password']),
                'phone1'=>$fields['phone1'],
                'balance'=>500,
                'isExp'=>$fields['isExp']
            ]);




            $expert = Expert::create([
                'user_id'=> $user->id,
                'country'=>$fields['country'],
                'city'=>$fields['city'],
                'rate' => 2.5,
                'skills'=>$fields['skills']
            ]);

            $WorksDays = $fields['days'];

            $days = Day::create([
                'user_id'=> $user->id,
                'sunday' => $WorksDays[0],
                'monday' => $WorksDays[1],
                'tuesday' => $WorksDays[2],
                'wednsday' => $WorksDays[3],
                'thursday' => $WorksDays[4],
                'friday' => $WorksDays[5],
                'saturday' => $WorksDays[6]
            ]);

            $expertCats = $fields['categories'];
            $experiences = array();
            //var_dump($expertCats);
            for($i=0;$i<sizeof($expertCats);$i++){
                if($expertCats[$i]['category_id']<=5){
                    $experiences[] = Experience::create([
                        'user_id' => $user->id,
                        'category_id' => $expertCats[$i]['category_id'],
                        'price' => $expertCats[$i]['price'],
                    ]);
                }else{
                    $cat=Category::Create([
                        'name' => $expertCats[$i]['category_name']
                    ]);
                    $experiences[] = Experience::Create([
                        'user_id' => $user->id,
                        'category_id' => $cat->id,
                        'price' => $expertCats[$i]['price'],
                    ]);
                }
            }

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



            $expertDuration =$fields['durations'];
            $checker =array();

            foreach ($expertDuration as $duration){
                $start = $duration['from'];
                $end = $duration['to'];
                for($i=$start;$i<$end;$i++){
                    if(in_array($i,$checker)){
                        return response()->json([
                            'status' => false,
                            'message' => "There is duration collision ,please check your durations",
                            'data' => ''
                        ],200);
                    }
                    $checker[] = $i;
                }
            }



            $durations = array();
            for($i=0;$i<sizeof($expertDuration);$i++){
                $durations[]=Duration::create([
                    'user_id' => $user->id,
                    'from' => $expertDuration[$i]['from'],
                    'to' => $expertDuration[$i]['to'],

                ]);
            }

            $token = $user->createToken('loginToken')->plainTextToken;


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
            return response()->json(
                [
                    'message' => "registered successfully",
                    'status' => true,
                    'data' => $expertGo
                ]
            ,201 );


    }

    public function registerExpertPhoto(Request $request)
{
    $user1 = Auth::user();
    try{
        $fields = $request->validate(
            [
                'img'=>'image|required'
            ]
            );

    }catch(Exception $e){
        return response()->json(
            [
                'message' => $e->getMessage(),
                'status' => false,
                'data' => ""
            ]
        ,200 );
    }
    $input = $request->all();
        if($request->hasFile('img'))
        {
            $filenameToStore = time().'.'.$request->img->extension();
            $request->img->move(public_path('images'),$filenameToStore);
            $input['imgUrl'] = URL::asset('images/'.$filenameToStore);
        }
        $id =$user1->id;
        $user = User::find($id);
        $user->img = $input['imgUrl'];
        $user->save();
        return response()->json(
            [
                'message' => "photo added successfully",
                'status' => true
            ]
        ,201 );
}

}


