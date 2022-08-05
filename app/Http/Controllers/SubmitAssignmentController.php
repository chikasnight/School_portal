<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubmitAssignment;
use App\Http\Resources\SubmitAssignmentResource;


class SubmitAssignmentController extends Controller
{
    public function assignmentSubmit(Request $request){
        //validate request body
        $request->validate([
            //'new_assignment'=>['string'],
            'submit_assignment'=>['string']
        ]);
        //create an Assignment
        $assignmentSubmit =  SubmitAssignment::create([
            'user_id'=>auth()->id(),
           // 'new_assignment'=> $request->new_assignment,
            'submit_assignment'=> $request->submit_assignment
            
        ]);
        /*if(Hash::check($request->submit_assignment, null(),)) {
            return response() ->json([
                'message' => 'Assignment created successfully'
            ]);
        }    */
        //return cuccess response

        return response()->json([
            'success'=> true,
            'message'=>'successfully submitted assignmentSubmit',
            'data' => new CommentResource($assignmentSubmit),
        ]);
    }
}
