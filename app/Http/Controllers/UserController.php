<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function UserRegistration(Request $request){

        try{
        $email=$request->input('email');
        $name=$request->input('name');
        $mobile=$request->input('mobile');
        $password=$request->input('password');


        User::create([
         'name'=>$name,
         'email'=>$email,
         'mobile'=>$mobile,
         'password'=>$password
        ]);

        return response()->json([
            'status'=>'success',
            'message'=>'User Registration Successfully!'
        ]);
        }
        catch(Exception $e){
            return response()->json([
            'status'=>'failed',
            'message'=>$e->getMessage()
        ], 200);
        };
        
    }

    function UserLogin(Request $request){

    }

    function UserLogout(Request $request){

    }

    function SendOTPCode(Request $request){

    }

     function VerifyOTP(Request $request){

    }

    function ResetPassword(Request $request){

    }

    function UserProfile(Request $request){

    }

    function UpdateProfile(Request $request){

    }
}
