<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function reserve(Request $request)
    {
        $fields = $request->validate([
            'experience_id' => 'required',
            'day' => 'required',
            'month' => 'required',
            'from' => 'required'
        ]);

        $user = Auth::user();



        $experience = DB::table('experiences')
                    ->where('id','=',$fields['experience_id'])
                    ->first();

        $expert = DB::table('experts')
                    ->where('user_id','=',$experience->user_id)
                    ->first();
        $expertUser = DB::table('users')
                        ->where('id','=',$experience->user_id)
                        ->first();

        $category = DB::table('categories')
                    ->where('id','=',$experience->category_id)
                    ->first();

        if($user->id == $expert->user_id){
            return response()->json([
                'status' => false,
                'message' => 'you can not reserve your experience',

            ],200);
        }


        $reservedTimes = DB::table('reservations')
                            ->where('expert_id','=',$experience->user_id)
                            ->get();

        foreach($reservedTimes as $reservedTime){
            if($fields['month']==$reservedTime->month){
                if($fields['day']==$reservedTime->day){
                    if($fields['from']==$reservedTime->from){
                        return response()->json([
                            'status' => false,
                            'message' => "this time is taken choose another time"
                        ],200);
                    }
                }
            }
        }


        if($user->balance < $experience->price){
            return response()->json([
                'status' => false,
                'message' => "You dont have money - please charge your wallet"
            ],200);
        }


        $editedUser = DB::table('users')
                    ->where('id','=',$user->id)
                    ->update(['balance' => $user->balance - $experience->price]);




        $editedExpert = DB::table('users')
                        ->where('id','=',$experience->user_id)
                        ->update(['balance' => $expertUser->balance + $experience->price]);



        $appointment = Reservation::create([
            'from' => $fields['from'],
            'day' => $fields['day'],
            'month' => $fields['month'],
            'user_id' => $user->id,
            'expert_id' => $expertUser->id,
            'category_id' => $category->id
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Appointment booked',
            'data' => $appointment
        ]);


    }






    public function history()
    {
        $user = Auth::user();

        $myAppointments = DB::table('reservations')
                            ->where('expert_id','=',$user->id)
                            ->get();

        $data = array();
        foreach ($myAppointments as $appointment){
            $appointmentUser = DB::table('users')
                                ->where('id','=',$appointment->user_id)
                                ->first();
            $userID = $appointmentUser->id;
            $userName = $appointmentUser->name;
            $day = $appointment->day;
            $month = $appointment->month;
            $from = $appointment->from;

            $packet =[
                "user_id" => $userID,
                "userName" => $userName,
                "day" => $day,
                "month" => $month,
                "from" => $from
            ];

            $data[] = $packet;

        }
        return response()->json([
            'status' => true,
            'message' => "done",
            'data' => $data
        ]);
    }


}
