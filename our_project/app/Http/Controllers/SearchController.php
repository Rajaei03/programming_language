<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search($NameofEx)
    {
        $cats = DB::table('categories')->where('name' , 'Like' , '%'.$NameofEx.'%')->get();
        if($cats->isEmpty())
        {
            return response()->json([
                'status' => false,
                'message' => "there is no such consultation"
            ],200);
        }

foreach ($cats as $cat)
{
    $exps = DB::table('experiences')->where('category_id' , 'Like' , $cat->id)->get();
    if($exps->isEmpty())
        {
            return response()->json([
                'status' => false,
                'message' => "there is no such consultation"
            ],200);
        }
    foreach ($exps as $exp)
    {
        $expert = DB::table('experts')->where('user_id','=',$exp->user_id)->first();
        $users = DB::table('users')->where('id' , 'Like' , $exp->user_id)->get();
        foreach ($users as $user)
        {
            $id = $exp->id;
            $name = $user->name;
            $price=$exp->price;
            $type=$cat->name;
            $rate=$expert->rate;
            $image_url = $user->img;
            $favorite_status = DB::table('favorites')
                ->where('user_id','Like', $user->id)->where('experience_id','Like', $id )
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
    }


}
return response()->json([
    'status' => true,
    'data' => $data
],200);

    }
}
