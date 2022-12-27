<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchByNameController extends Controller
{
    public function searchbyname($NameofExpert)
    {
        $users = DB::table('users')->where('name' , 'Like' , '%'.$NameofExpert.'%')->where('isExp' , 'Like' , 1)->get();
        if($users->isEmpty())
        {
            return response()->json([
                'status' => false,
                'message' => "there is no such name"
            ],200);
        }
foreach ($users as $user)
{
    $exps = DB::table('experiences')->where('user_id' , 'Like' , '%'.$user->id.'%')->get();
    foreach ($exps as $exp)
    {
        $cats = DB::table('categories')->where('id' , 'Like' , '%'.$exp->category_id.'%')->get();
        foreach ($cats as $cat)
        {
            $id = $exp->id;
            $name = $user->name;
            $price=$exp->price;
            $type=$cat->name;
            $packet =
            [
                'id' => $id,
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
