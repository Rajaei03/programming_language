<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchByNameController extends Controller
{
    public function searchbyname($NameofExpert)
    {
        $users = DB::table('users')->where('name' , 'Like' , '%'.$NameofExpert.'%')->where('isExp' , 'Like' , 1)->get();

foreach ($users as $user)
{
    $exps = DB::table('experiences')->where('user_id' , 'Like' , '%'.$user->id.'%')->get();
    foreach ($exps as $exp)
    {
        $cats = DB::table('categories')->where('id' , 'Like' , '%'.$exp->category_id.'%')->get();
        foreach ($cats as $cat)
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