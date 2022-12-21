<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search( $name)
    {
        $cats = DB::table('categories')->where('name' , 'Like' , '%'.$name.'%')->get();

foreach ($cats as $cat)
{
    $exps = DB::table('experiences')->where('category_id' , 'Like' , '%'.$cat->id.'%')->get();
    foreach ($exps as $exp)
    {
        $users = DB::table('users')->where('id' , 'Like' , '%'.$exp->user_id.'%')->get();
        foreach ($users as $user)
        {
            $packet = [
                $user->name,$user->id
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
