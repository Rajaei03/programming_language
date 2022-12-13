<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Expert;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile($id)
    {
        $resp = [
            User::find($id)
        ];

        return response()->json([
            
        ]);
    }
}
