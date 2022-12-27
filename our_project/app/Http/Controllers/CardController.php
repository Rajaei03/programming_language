<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CardController extends Controller
{
    public function card($id)
    {
        $exp = DB::table('experiences')->where('id', 'Like', $id)->first();
        if($exp==null)
        {
            return response()->json([
                'status' => false,
                'message' => "there is no such card"
            ],200);
        }
        $user = DB::table('users')->where('id' , 'Like' , $exp->user_id)->first();
        $days = DB::table('days')->where('user_id' , 'Like' , $user->id)->first();
        $durations = DB::table('durations')->where('user_id' , 'Like' , $user->id)->get();
        $cat = DB::table('categories')->where('id' , 'Like' , $exp->category_id)->first();
        $name = $user->name;
        $expertid = $user->id;
        $price=$exp->price;
        $type=$cat->name;
        foreach($durations as $duration)
        {
            for($i=$duration->from;$i<$duration->to;$i++)
            {
                $worktime =$i;
                $worktimes[]  = $worktime;
            }
        }
        $int = intval($id);

        $packet =
        [
            "name" => $name,
            "expert_id" =>$expertid,
            "experience_id" => $int,
            "type" => $type,
            "price" => $price,
            "days" => $days,
            "worktimes" => $worktimes
        ];
        $data = $packet;
        return response()->json([
            'status' => true,
            'data' => $data
        ],200);
    }
}

