<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Expert;
use Illuminate\Http\Request;

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
}
