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
            $response =[
                'user' => $user
            ];
            return response()->json([
                'status' => true,
                'message' => 'done',
                'data' => $response
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
        $experiencesReady = array();
        foreach ($experiences as $experience){
            $id = $experience->id;
            $user_id = $experience->user_id;
            $category_id = $experience->category_id;
            $category = DB::table('categories')
                            ->where('id','=',$category_id)
                            ->first();
            $category_name = $category->name;
            $price  = $experience->price;
            $packet = [
                'id' => $id,
                'user_id' => $user_id,
                'category_id' => $category_id,
                'category_name' => $category_name,
                'price' => $price
            ];
            $experiencesReady[] = $packet;
        }

        $durations = DB::table('durations')
                        ->where('user_id','=',$user->id)
                        ->get();

        $response = [

            'expertInfo' => $expert,
            'days' => $days,
            'experiences' => $experiencesReady,
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
        $experiencesReady = array();
        foreach ($experiences as $experience){
            $id = $experience->id;
            $user_id = $experience->user_id;
            $category_id = $experience->category_id;
            $category = DB::table('categories')
                            ->where('id','=',$category_id)
                            ->first();
            $category_name = $category->name;
            $price  = $experience->price;
            $packet = [
                'id' => $id,
                'user_id' => $user_id,
                'category_id' => $category_id,
                'category_name' => $category_name,
                'price' => $price
            ];
            $experiencesReady[] = $packet;
        }

        $durations = DB::table('durations')
                        ->where('user_id','=',$user->id)
                        ->get();

        $response = [

            'expertInfo' => $expert,
            'days' => $days,
            'experiences' => $experiencesReady,
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

    public function rate(Request $request)
    {
        $user = Auth::user();

        $fields = $request->validate([
            'expert_id' => 'required',
            'rate' => 'required'
        ]);

        $checker = DB::table('reservations')
                        ->where('user_id','=',$user->id)
                        ->where('expert_id',$fields['expert_id'])
                        ->first();

        if($checker == null){
            return response()->json([
                'status' => false,
                'message' => "You can't rate an expert you haven't tried"
            ]);
        }

        $expert = DB::table('experts')
                    ->where('user_id',$fields['expert_id'])
                    ->first();
        $sumRating = $expert->rate * $expert->numRated;

        $sumRating = $sumRating + $fields['rate'];

        $rate = $sumRating / ($expert->numRated+1);

        $updatedExp = DB::table('experts')
                            ->where('user_id',$fields['expert_id'])
                            ->update(['rate' => $rate,'numRated' => $expert->numRated+1]);

        return response()->json([
            'status' => true,
            'message' => "successfully rated"
        ]);





    }


}
