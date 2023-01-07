<?php

namespace App\Http\Controllers;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isEmpty;

class FavoriteController extends Controller
{
    public function favorite(Request $request)
    {
        $fields = $request->validate(
            [
                'experience_id'=>'required',
            ]);

            $user = Auth::user();
            $favs = DB::table('favorites')->where('user_id' , 'Like' , $user->id)->get();
            foreach($favs as $fav)
            {
                if($fav->experience_id == $fields['experience_id'])
            {

                $deleted = DB::table('favorites')
            ->where('user_id','Like', $user->id)->Where('experience_id','Like', $fields['experience_id'])
            ->delete();

                return response()->json(
                    [
                        'message' => "removerd from favorites",
                        'status' => true
                    ]
                ,201 );
            }
            }

            $favourite = favorite::create([
                'user_id' => $user->id,
                'experience_id' => $fields['experience_id']
            ]);
            return response()->json(
                [
                    'message' => "added to favorites",
                    'status' => true
                ]
            ,201 );
    }

    public function showfavorite()
    {
        $user = Auth::user();
        $favs = DB::table('favorites')->where('user_id' , 'Like' , $user->id)->get();
        if($favs->isEmpty())
        {

            return response()->json([
                'status' => false,
                'data' => []
            ],200);
        }
        else
        {
        foreach($favs as $fav)
        {
            $experience = DB::table('experiences')->where( 'id' , 'Like' , $fav->experience_id )->first();
            $user = DB::table('users')
            ->where('id','Like',$experience->user_id)
            ->first();
            $expert = DB::table('experts')
            ->where('user_id','Like',$experience->user_id)
            ->first();
            $category = DB::table('categories')
                    ->where('id','Like',$experience->category_id)
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
                "favorite_status" => true
            ];
            $data[] = $packet;
        }
        return response()->json([
            'status' => true,
            'data' => $data
        ],200);
    }}
}
