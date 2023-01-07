<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Expert;
use App\Models\Category;
use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
            $image_url = $user->img;



            $packet = [
                'id' => $id,
                "name" => $name,
                "price" => $price,
                "type" => $type,
                "rate" => $rate,
                "image_url" => $image_url,
                "favorite_status" => false
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
                $image_url = $user->img;


                $packet = [
                    'id' => $id,
                    "name" => $name,
                    "price" => $price,
                    "type" => $type,
                    "rate" => $rate,
                    "image_url" => $image_url,
                    "favorite_status" => false
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
                $image_url = $user->img;


                $packet = [
                    'id' => $id,
                    "name" => $name,
                    "price" => $price,
                    "type" => $type,
                    "rate" => $rate,
                    "image_url" => $image_url,
                    "favorite_status" => false
                ];

                $data[] = $packet;

            }



            return response()->json([
                'status' => true,
                'data' => $data
            ],200);
        }
    }

    public function homewithtoken(Request $request)
    {
        $user1 = Auth::user();
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
            $image_url = $user->img;
            $favorite_status = DB::table('favorites')
            ->where('user_id','Like', $user1->id)->where('experience_id','Like', $id )
            ->first();
            if($favorite_status==null)
            {
                $packet = [
                    'id' => $id,
                    "name" => $name,
                    "price" => $price,
                    "type" => $type,
                    "rate" => $rate,
                    "image_url" => $image_url,
                    "favorite_status" => false
                ];
            }else
            {
            $packet = [
                'id' => $id,
                "name" => $name,
                "price" => $price,
                "type" => $type,
                "rate" => $rate,
                "image_url" => $image_url,
                "favorite_status" => true
            ];
            }
            $data[] = $packet;

        }



        return response()->json([
            'status' => true,
            'data' => $data
        ],200);
    }




    public function homeFilterwithroken(Request $request,$id)
    {
        $user1 = Auth::user();
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
                $image_url = $user->img;
                $favorite_status = DB::table('favorites')
                ->where('user_id','Like', $user1->id)->where('experience_id','Like', $id )
                ->first();
                if($favorite_status==null)
                {
                    $packet = [
                        'id' => $id,
                        "name" => $name,
                        "price" => $price,
                        "type" => $type,
                        "rate" => $rate,
                        "image_url" => $image_url,
                        "favorite_status" => false
                    ];
                }else
                {
                $packet = [
                    'id' => $id,
                    "name" => $name,
                    "price" => $price,
                    "type" => $type,
                    "rate" => $rate,
                    "image_url" => $image_url,
                    "favorite_status" => true
                ];
                }
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
                $image_url = $user->img;
                $favorite_status = DB::table('favorites')
                ->where('user_id','Like', $user1->id)->where('experience_id','Like', $id )
                ->first();
                if($favorite_status==null)
                {
                    $packet = [
                        'id' => $id,
                        "name" => $name,
                        "price" => $price,
                        "type" => $type,
                        "rate" => $rate,
                        "image_url" => $image_url,
                        "favorite_status" => false
                    ];
                }else
                {
                $packet = [
                    'id' => $id,
                    "name" => $name,
                    "price" => $price,
                    "type" => $type,
                    "rate" => $rate,
                    "image_url" => $image_url,
                    "favorite_status" => true
                ];
                }
                $data[] = $packet;

            }



            return response()->json([
                'status' => true,
                'data' => $data
            ],200);



            return response()->json([
                'status' => true,
                'data' => $data
            ],200);
        }
    }

}
