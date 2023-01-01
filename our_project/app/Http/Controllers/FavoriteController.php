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
                        'message' => "deleted successfully",
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
                    'message' => "Added successfully",
                    'status' => true
                ]
            ,201 );
    }
}
