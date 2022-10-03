<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;   
use App\Http\Resources\AssignmentResource;
use Illuminate\Support\Facades\Hash;

class AssignmentController extends Controller
{
    public function assignment(Request $request){
        //validate request body
        $request->validate([
            'new_assignment'=>['string'],
            //'submit_assignment'=>['string']
        ]);
        //create an Assignment
        $assignment =  Assignment::create([
            'user_id'=>auth()->id(),
            'new_assignment'=> $request->new_assignment,
           // 'submit_assignment'=> $request->submit_assignment
            
        ]);
        /*if(Hash::check($request->submit_assignment, null(),)) {
            return response() ->json([
                'message' => 'Assignment created successfully'
            ]);
        }    */
        //return cuccess response

        return response()->json([
            'success'=> true,
            'message'=>'successfully created an assignment',
            'data' => new AssignmentResource($assignment),
        ]);
    }
    public function getAssignment(Request $request, $assignmentId){
        $assignment = Assignment::find($assignmentId);
        if(!$assignment) {
            return response() ->json([
                'success' => false,
                'message' => 'assignment not found'
            ]);
        }

        return response() ->json([
            'success'=> true,
            'message'  => 'assignment found',
            'data'   => [
                'assignment'=> new AssignmentResource($assignment),
                
            ]
        ]);
    }
}
