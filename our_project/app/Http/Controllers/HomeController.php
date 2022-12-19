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
        $data = Experience::all();

        return response()->json([
            'status' => 'done',
            'data' => $data
        ],200);
    }

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
            var_dump($user->name);
        }
    }


}


        // $ids = Category::where('name' , 'Like' , '%'.$name.'%')->select('id')->get();
        // $ids2 = Experience::where('category_id' , 'Like' , $ids)->select('user_id')->get();
        // return User::where('id' , 'Like' , $ids2 ) -> select('name')->get();
        //return User::where('name' , 'Like' , '%'.$name.'%' ) -> select('name')->get();
    }

}