<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function createChat(Request $request)
    {
        $user = Auth::user();

        $fields = $request->validate([
            'expert_id' => 'required'
        ]);

        if($user->id == $fields['expert_id']){
            return response()->json([
                'status' => false,
                'message' => "you can contact your self",
                'data' => ''
            ]);
        }

        $chatVal = DB::table('chats')
                    ->where('user_id','=',$user->id)
                    ->Where('expert_id','=',$fields['expert_id'])
                    ->first();

        if($chatVal != null){
            return response([
                'status' => false,
                'message' => "you already have chat with this person",
                'data' => $chatVal
            ]);
        }

        $chat = Chat::create([
            'user_id' => $user->id,
            'expert_id' => $fields['expert_id']
        ]);

        return response()->json([
            'status' => true,
            'message' => "cretaed",
            'data' => $chat
        ]);
    }





    public function getChat()
    {
        $user = Auth::user();

        $chats = DB::table('chats')
                    ->where('user_id','=',$user->id)
                    ->orWhere('expert_id','=',$user->id)
                    ->orderBy('updated_at', 'desc')
                    ->get();

        $chatsReady = array();
        foreach($chats as $chat){
            $lastMessage = DB::table('messages')
                            ->where('chat_id','=',$chat->id)
                            ->latest('created_at')
                            ->first();

            if($lastMessage != null){
                $lastMessageMessage = $lastMessage->message;
                $lastMessageTime = $lastMessage->created_at ;
            }else{
                $lastMessageMessage = "";
                $lastMessageTime = "" ;
            }

            if($user->id == $chat->user_id){
                $chatUser = DB::table('users')
                                ->where('id','=',$chat->expert_id)
                                ->first();
            }else{
                $chatUser = DB::table('users')
                                ->where('id','=',$chat->user_id)
                                ->first();
            }

            $name = $chatUser->name;

            $packet = [
                'name' => $name,
                'lastMessage' => $lastMessageMessage,
                'lastMessageTime' => $lastMessageTime
            ];

            $chatsReady[] = $packet;

        }

        return response()->json([
            'status' => true,
            'message' => "done",
            'data' => $chatsReady
        ]);
    }





    public function getMessage(Request $request)
    {
        $user = Auth::user();

        $fields = $request->validate([
            'chat_id' => 'required'
        ]);

        $messages = DB::table('messages')
                        ->where('chat_id','=',$fields['chat_id'])
                        ->get();


        $messagesReady = array();
        foreach($messages as $message){
            if($message->sender_id == $user->id){
                $myMessage = true;
            }else{
                $myMessage = false;
            }

            $packet = [
                'message' => $message->message,
                'isMyMessage' => $myMessage
            ];

            $messagesReady[] = $packet;
        }


        return response()->json([
            'status' => true,
            'message' => "done",
            'date' => $messagesReady
        ]);


    }



    public function createMessage(Request $request)
    {
        $user = Auth::user();

        $fields = $request->validate([
            'chat_id' => 'required',
            'message' => 'required'
        ]);

        $message = message::create([
            'chat_id' => $fields['chat_id'],
            'sender_id' => $user->id,
            'message' => $fields['message'],
        ]);

        $chat = Chat::find($fields['chat_id']);

        $chat->touch();

        $messages = DB::table('messages')
                        ->where('chat_id','=',$fields['chat_id'])
                        ->get();


        $messagesReady = array();
        foreach($messages as $message){
            if($message->sender_id == $user->id){
                $myMessage = true;
            }else{
                $myMessage = false;
            }

            $packet = [
                'message' => $message->message,
                'isMyMessage' => $myMessage
            ];

            $messagesReady[] = $packet;
        }


        return response()->json([
            'status' => true,
            'message' => "done",
            'date' => $messagesReady
        ]);

    }


}
