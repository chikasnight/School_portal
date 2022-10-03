<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    //add image tp the trgister table
    public function register(Request $request) {
      
        $request->validate([
            'name'=>['required'],
            'phone'=>['required', 'min:11'],
            'email'=>['required', 'unique:users,email'],
            'password'=>['required', 'min:6', 'confirmed'],
            //'image' => ['mimes:png,jpeg,gif,bmp', 'max:2048','required'],
            

        ]);
        
        /*//get the image
        $image = $request->file('image');
        //$image_path = $image->getPathName();
 
        // get original file name and replace any spaces with _
        // example: ofiice card.png = timestamp()_office_card.pnp
        $filename = time()."_".preg_replace('/\s+/', '_', strtolower($image->getClientOriginalName()));
 
        // move image to temp location (tmp disk)
        $tmp = $image->storeAs('uploads/original', $filename, 'tmp');*/
 
        //create user
        $user = User::create([
            'name' => $request-> name,
            'phone' => $request-> phone,
            'email'=> $request-> email,
            'password' => Hash::make($request->password),
            //'image'=> $filename,
            //'disk'=> config('site.upload_disk'),
           
        ]);
        
        //dispacth job to handle image manipulation
        /*$this->dispatch(new UploadImage($image));*/


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
            'current_password'=>['required', new CheckPassword()],
            'new_password'=>['required','confirmed']
        ]);

        $user= auth('sanctum')->user();
        /*if( Hash::check($request->new_password, $user->password)){
            return response()->json([
                'success'=> false,
                'message'=>'password matches with current password',
                
            ]);

        }*/

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
        $task =new User();
        $query =$task-> newQuery();

        if($request->has('name')){
            $query= $query->where('name', $request->name);
        
        }


        
        return response()->json([
            'success'=> true,
            'message'=>'search results found',
            'data'=> $query->get()

            
        ]);
        
    }
    public function getAllUser(Request $request, $userId){
        $user = User::find($userId);
        if(!$user) {
            return response() ->json([
                'success' => false,
                'message' => 'user not found'
            ]);
        }

        return response() ->json([
            'success'=> true,
            'message'  => 'user found',
            'data'   => [
                'user'=> new UserResource($user),
                
            ]
        ]);
    }
    public function updateProfile(Request $request){
        $request->validate([
            'current_name'=>['required'],
            'new_name'=>['required','confirmed'],
            'new_image' => ['mimes:png,jpeg,gif,bmp', 'max:2048','required']
            
        ]);

        $user= auth('sanctum')->user();
        if( Hash::check($request->new_name, $user->name)){
            return response()->json([
                'success'=> false,
                'message'=>'name matches with current name',
                
            ]);

        }
        
        $user ->update(['name'=> Hash::make($request->new_name)]);
        $user ->update(['image'=> Hash::make($request->new_image)]);

        
        //dwlete any other existing token for user
        $user->tokens()-> delete();

        //create a new token
        $token = $user -> createtoken('login')->plainTextToken;


        
        return response()->json([
            'success'=> true,
            'message'=>'profile updated',
            'data' =>['token'=> $token]
        ]);
    } 
}
