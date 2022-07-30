<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use Illuminate\Support\Facades\Hash;

class AssignmentController extends Controller
{
    public function assignment(Request $request){
        //validate request body
        $request->validate([
            'new_assignment'=>['string'],
            'submit_assignment'=>['string']
        ]);
        //create a blog post
        $assignment =  Assignment::create([
            'user_id'=>auth()->id(),
            'new_assignment'=> $request->new_assignment,
            'submit_assignment'=> $request->submit_assignment
            
        ]);
        if(Hash::check($request->submit_assignment, null(),)) {
            return response() ->json([
                'message' => 'Assignment created successfully'
            ]);
        }    
        //return cuccess response

        return response()->json([
            'success'=> true,
            'message'=>'successfully created a comment',
            'data' => new CommentResource($newBlogComment),
        ]);
    }
}
