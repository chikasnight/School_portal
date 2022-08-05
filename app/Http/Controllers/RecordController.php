<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record;
use App\Http\Resources\RecordResource;


class RecordController extends Controller
{
    public function record(Request $request){
        //validate request body
        $request->validate([
            'student_name'=>['required'],
            'teacher_name'=>['required'],
            'subject'=>['required'],
            'ca'=>['required'],
            'exams'=>['required'],
            'total'=>['required']
        ]);
        //create a new Record
        $Record = Record::create([
            'user_id'=>auth()->id(),
            'student_name'=> $request->student_name,
            'teacher_name'=> $request->teaccher_name,
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
    public function editRecord(Request $request, $recordId){
        $request->validate([
            'ca'=>['required'],
            'exams'=>['required'],
            'total'=>['required'],
            
        ]);
        
        $record = Record::find($recordId);
        if(!$record) {
            return response() ->json([
                'success' => false,
                'message' => 'record not found'
            ]);

        }
        $this->authorize('update',$record);


        $record->ca = $request->ca;
        $record->exams = $request->exams;
        $record->total = $request->total;
        $record->save();
        return response() ->json([
            'success' => true,
            'message' => 'record updated'
        ]);
    } 
    public function getRecord(Request $request, $recordId){
        $record = Record::find($recordId);
        if(!$record) {
            return response() ->json([
                'success' => false,
                'message' => 'record not found'
            ]);
        }

        return response() ->json([
            'success'=> true,
            'message'  => 'record found',
            'data'   => [
                'record'=> new RecordResource($record),
                
            ]
        ]);
    }
}
