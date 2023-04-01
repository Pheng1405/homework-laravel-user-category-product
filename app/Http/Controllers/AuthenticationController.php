<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Hash;
use Throwable;

class AuthenticationController extends Controller
{
    //

    public function register(Request $request){
       
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            // 'profile' => 'required'
        ]);

        $user =User::where('email', $request->email)->first();

        if($user){
            return response([
                'message' => "email or user already used"
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'is_admin' => $request->is_admin,
            // 'profile_url' => Cloudinary::upload($request->file('profile')->getRealPath())->getSecurePath(),
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_token')->accessToken;

        return response([
            'token' => $token,
            'user' => $user
        ],201);
        

    }
    public function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user =User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return response([
                'message' => 'The provided credential are incorrect...!', 
            ],401);
        }

        if($token = $user->createToken('auth_token')->accessToken){
            return response([
                    'token' => $token,
                    'credential' => $user
            ],200);
        }

        

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    // public function logout(Request $request){
    //     $request->user()->token()->revoke();

    //     return response([
    //         'message'=>'Logged out successfully'
    //     ]);
    // }
    

}
