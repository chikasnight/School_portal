<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function register(Request $request) {
      
        $request->validate([
            'name'=>['required'],
            'phone'=>['required'],
            'email'=>['required', 'unique:users,email'],
            'password'=>['required', 'min:6', 'confirmed']

        ]);
        //create user
        $user = User::create([
            'name' => $request-> name,
            'phone' => $request-> phone,
            'email'=> $request-> email,
            'password' => Hash::make($request->password)
        ]);


        //create token
        $token = $user -> createtoken('default')->plainTextToken;

        return response()->json([
            'success'=> true,
            'message'=>'registration successful',
            'data' =>[
                'token' => $token,
                'user' => new UserResource ($user)
            ]
        ]);        
    }
    
    public function login(Request $request){
        $request->validate([
            'email'=>['required'],
            'password'=>['required'],
        ]);
        //check user with email and check if password is correct
        $user = User::where('email', $request->email)->first();
        
        
        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                'success'=> false,
                'message'=>'incorrect email or password'
    
                
            ]);
        }

        //dwlete any other existing token for user
        $user->tokens()-> delete();

        //create a new token
        $token = $user -> createtoken('login')->plainTextToken;

        //return token
        return response()->json([
            'success'=> true,
            'message'=>'login successful',
            'data' =>[
                'token' => $token,
                
            ]
        ]); 

    }

    public function logout(Request $request){
        auth('sanctum')->user()->tokens()->delete();
        return response()->json([
            'success'=> true,
            'message'=>' user logged out'
        ]);
    }


    public function changePassword(Request $request){
        $request->validate([
            'current_password'=>['required', new CheckCurrentPassword()],
            'new_password'=>['required',/*new CompareNewPasswordWithOld()*/ 'confirmed']
        ]);

        $user= auth('sanctum')->user();
        if( Hash::check($request->new_password, $user->password)){
            return response()->json([
                'success'=> false,
                'message'=>'password matches with current password',
                
            ]);

        }

        $user ->update(['password'=> Hash::make($request->new_password)]);

        
        //dwlete any other existing token for user
        $user->tokens()-> delete();

        //create a new token
        $token = $user -> createtoken('login')->plainTextToken;


        
        return response()->json([
            'success'=> true,
            'message'=>'password updated',
            'data' =>['token'=> $token]
        ]);
    } 
    public function search(Request $request){
        $task =new Grocery();
        $query =$task-> newQuery();

        if($request->has('name')){
            $query= $query->where('name', $request->name);
        
        }

        if($request->has('price')){
            $query= $query->where('price', $request->price);
        }
        if($request->has('category')){
            $query= $query->where('category', $request->category);
        }
        

        
        return response()->json([
            'success'=> true,
            'message'=>'search results found',
            'data'=> $query->get()

            
        ]);
        
    }
    public function getAllUser(Request $request, $groceryId){
        $grocery = Grocery::find($groceryId);
        if(!$grocery) {
            return response() ->json([
                'success' => false,
                'message' => 'grocery not found'
            ]);
        }

        return response() ->json([
            'success'=> true,
            'message'  => 'grocery found',
            'data'   => [
                'grocery'=> new GroceryResource($grocery),
                
            ]
        ]);
    }
    public function updateProfile(Request $request){
        $request->validate([
        'current_name'=>['required', /*new CheckPassword()],*/ ],
            'new_name'=>['required',/*new CheckIfNewPassMatchWithOld(),*/ 'confirmed']
        ]);

        $user= auth('sanctum')->user();
        if( Hash::check($request->new_name, $user->name)){
            return response()->json([
                'success'=> false,
                'message'=>'name matches with current name',
                
            ]);

        }

        $user ->update(['name'=> Hash::make($request->new_name)]);

        
        //dwlete any other existing token for user
        $user->tokens()-> delete();

        //create a new token
        $token = $user -> createtoken('login')->plainTextToken;


        
        return response()->json([
            'success'=> true,
            'message'=>'name updated',
            'data' =>['token'=> $token]
        ]);
    } 
}
