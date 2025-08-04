<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helper\JWTToken;
use Exception;

class UserController extends Controller
{
    function UserRegistration(Request $request)
    {

        try {
            $email = $request->input('email');
            $name = $request->input('name');
            $mobile = $request->input('mobile');
            $password = $request->input('password');


            User::create([
                'name' => $name,
                'email' => $email,
                'mobile' => $mobile,
                'password' => $password
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'User Registration Successfully!'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ], 200);
        };
    }

   function UserLogin(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();

        if ($user && Hash::check($request->input('password'), $user->password)) {
            $tokenPayload = json_encode([
                'email' => $user->email,
                'id' => $user->id
            ]);
            $token = JWTToken::CreateToken($tokenPayload, $user->id);

            return response()->json([
                'status' => 'success',
                'message' => 'User Login Successfully!',
                'token' => $token
            ], 200)->cookie('token', $token, time() + 60 * 24 * 30);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorized'
            ], 200);
        }
    }

    function UserLogout(Request $request) {
      return response()->json([
        'status' => 'success',
        'message' => 'Logged out successfully'
    ])->cookie('token', '', -1);
}


    function SendOTPCode(Request $request) {}

    function VerifyOTP(Request $request) {}

    function ResetPassword(Request $request) {}

    function UserProfile(Request $request) {}

    function UpdateProfile(Request $request) {}
}
