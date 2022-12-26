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
    $exps = DB::table('experiences')->where('category_id' , 'Like' , '%'.$cat->id.'%')->get();
    foreach ($exps as $exp)
    {
        $users = DB::table('users')->where('id' , 'Like' , '%'.$exp->user_id.'%')->get();
        foreach ($users as $user)
        {
            $name = $user->name;
            $price=$exp->price;
            $type=$cat->name;
            $packet =
            [
                "name" => $name,
                "price" => $price,
                "type" => $type
            ];
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
