<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Expert;
use App\Models\Category;
use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        $experiences = DB::table('experiences')
                    ->get();

        $data = array();

        foreach($experiences as $experience){
            $user = DB::table('users')
                    ->where('id','=',$experience->user_id)
                    ->first();

            $expert = DB::table('experts')
                    ->where('user_id','=',$experience->user_id)
                    ->first();

            $category = DB::table('categories')
                    ->where('id','=',$experience->category_id)
                    ->first();
            $id = $experience->id;
            $name=$user->name;
            $price=$experience->price;
            $type=$category->name;
            $rate=$expert->rate;



            $packet = [
                'id' => $id,
                "name" => $name,
                "price" => $price,
                "type" => $type,
                "rate" => $rate
            ];

            $data[] = $packet;

        }



        return response()->json([
            'status' => true,
            'data' => $data
        ],200);
    }





    public function homeFilter(Request $request,$id)
    {
        if($id<6){
            $experiences = DB::table('experiences')
                        ->where('category_id', '=', $id)
                        ->get();

            $data = array();

            foreach($experiences as $experience){
                $user = DB::table('users')
                        ->where('id','=',$experience->user_id)
                        ->first();

                $expert = DB::table('experts')
                            ->where('user_id','=',$experience->user_id)
                            ->first();

                $category = DB::table('categories')
                        ->where('id','=',$experience->category_id)
                        ->first();

                $id = $experience->id;
                $name=$user->name;
                $price=$experience->price;
                $type=$category->name;
                $rate=$expert->rate;


                $packet = [
                    'id' => $id,
                    "name" => $name,
                    "price" => $price,
                    "type" => $type,
                    "rate" => $rate
                ];

                $data[] = $packet;

            }



            return response()->json([
                'status' => true,
                'data' => $data
            ],200);
        }else{
            $experiences = DB::table('experiences')
                        ->where('category_id', '>', 5)
                        ->get();

            $data = array();

            foreach($experiences as $experience){
                $user = DB::table('users')
                        ->where('id','=',$experience->user_id)
                        ->first();

                $expert = DB::table('experts')
                           ->where('user_id','=',$experience->user_id)
                           ->first();

                $category = DB::table('categories')
                        ->where('id','=',$experience->category_id)
                        ->first();
                $id = $experience->id;
                $name=$user->name;
                $price=$experience->price;
                $type=$category->name;
                $rate=$expert->rate;


                $packet = [
                    'id' => $id,
                    "name" => $name,
                    "price" => $price,
                    "type" => $type,
                    "rate" => $rate
                ];

                $data[] = $packet;

            }



            return response()->json([
                'status' => true,
                'data' => $data
            ],200);
        }
    }
}
