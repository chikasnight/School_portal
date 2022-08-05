<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Http\Resources\MessageResource;

class MessageController extends Controller
{
    public function message(Request $request){
        //validate request body
        $request->validate([
            'message'=>['required']
        ]);
        //create a new message
        $message = Message::create([
            'user_id'=>auth()->id(),
            'message'=> $request->message
            
        ]);
        
        //return cuccess response

        return response()->json([
            'success'=> true,
            'message'=>'successfully created a message',
            'data' => /*new MessageResource(*/$message,
        ]);
    }
    public function getMessage(Request $request, $messageId){
        $message = Message::find($messageId);
        if(!$message) {
            return response() ->json([
                'success' => false,
                'message' => 'message not found'
            ]);
        }

        return response() ->json([
            'success'=> true,
            'message'  => 'message found',
            'data'   => [
                'message'=> new MessageResource($message),
                
            ]
        ]);
    }
}
