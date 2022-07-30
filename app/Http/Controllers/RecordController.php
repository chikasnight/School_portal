<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecordController extends Controller
{
    public function Record(Request $request){
        //validate request body
        $request->validate([
            'student_name'=>['required'],
            'teaccher_name'=>['required'],
            'subject'=>['required'],
            'ca'=>['required'],
            'exams'=>['required'],
            'total'=>['required']
        ]);
        //create a new Record
        $Record = Record::create([
            'user_id'=>auth()->id(),
            'student_name'=> $request->student_name,
            'teaccher_name'=> $request->teaccher_name,
            'subject'=> $request->subject,
            'ca,'=> $request->ca,
            'exams,'=> $request->exams,
            'total'=> $request->total
            
        ]);
        
        //return success response

        return response()->json([
            'success'=> true,
            'message'=>'successfully created a student Record',
            'data' => /*new RecordResource(*/$Record,
        ]);
    } 
}