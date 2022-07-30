<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function notice(Request $request){
        //validate request body
        $request->validate([
            'notice'=>['required']
        ]);
        //create a new notice
        $notice = Notice::create([
            'user_id'=>auth()->id(),
            'notice'=> $request->notice
            
        ]);
        
        //return success response

        return response()->json([
            'success'=> true,
            'message'=>'successfully created a notice',
            'data' => /*new noticeResource(*/$notice,
        ]);
    } 
}
