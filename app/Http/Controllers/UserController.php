<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helper\JWTToken;
use Exception;
use Illuminate\Support\Facades\Mail;
use App\Mail\OTPMail;
use Inertia\Inertia;

class UserController extends Controller
{
    function Registration()
    {
        return Inertia::render('Registration');
    }

    function Login()
    {
        return Inertia::render('Login');
    }

    function ResetPasswordPage()
    {
        return Inertia::render('ResetPassword');
    }

    function SendOTPPage()
    {
        return Inertia::render('SendOTP');
    }

    function VerifyOTPPage()
    {
        return Inertia::render('VerifyOTP');
    }


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
                'password' => bcrypt($password)
            ]);

            $data = ['message' => 'Registration Successful', 'status' => true, 'error' => ''];
            return redirect()->route('Login')->with($data);
        } catch (Exception $e) {
            $data = ['message' => 'Registration Failed', 'status' => false, 'error' => $e->getMessage()];
            return redirect()->back()->with($data);
        }
    }


    function UserLogin(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Store session
            $request->session()->put('email', $user->email);
            $request->session()->put('user_id', $user->id);

            $data = ['message' => 'Login Successful', 'status' => true];
            return redirect()->route('Dashboard')->with($data);
        } else {
            $data = ['message' => 'Login Failed', 'status' => false];
            return redirect()->route('Login')->with($data);
        }
    }
    function UserLogout(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully'
        ])->cookie('token', '', -1);
    }


    function SendOTPCode(Request $request)
    {

        $email = $request->input('email');
        $otp = rand(1000, 9999);
        $count = User::where('email', '=', $email)->count();
        if ($count == 1) {
            Mail::to($email)->send(new OTPMail($otp));
            User::where('email', '=', $email)->update(['otp' => $otp]);
            return response()->json([
                'status' => 'success',
                'message' => "4 Digit {$otp} Code has been send to your email !"
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorized'
            ]);
        }
    }


    function VerifyOTP(Request $request)
    {
        $email = $request->input('email');
        $otp = $request->input('otp');
        $count = User::where('email', '=', $email)
            ->where('otp', '=', $otp)->count();

        if ($count == 1) {
            User::where('email', '=', $email)->update(['otp' => '0']);
            $token = JWTToken::CreateTokenForSetPassword($request->input('email'));
            return response()->json([
                'status' => 'success',
                'message' => 'OTP Verification Successful',
                'token' => $token
            ], 200)->cookie('token', $token, 60 * 24 * 30);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorized'
            ], 200);
        }
    }

    function ResetPassword(Request $request)
    {

        try {
            $email = $request->header('email');
            $password = $request->input('password');
            User::where('email', '=', $email)->update(['password' => $password]);
            return response()->json([
                'status' => 'success',
                'message' => 'Request Successful',
            ], 200);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Something Went Wrong',
            ], 200);
        }
    }

    function UserProfile(Request $request)
    {
        $email = $request->header('email');
        $user = User::where('email', '=', $email)->first();
        return response()->json([
            'status' => 'success',
            'message' => 'Request Successful',
            'data' => $user
        ], 200);
    }


    public function UpdateProfile(Request $request)
    {
        try {
            $email = $request->header('email');
            if (!$email) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Email header missing',
                ], 400);
            }

            $user = User::where('email', $email)->first();
            if (!$user) {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'User not found',
                ], 404);
            }

            $user->update([
                'name' => $request->input('name'),
                'mobile' => $request->input('mobile'),
                'password' => bcrypt($request->input('password'))
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Profile updated successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Something went wrong',
            ], 500);
        }
    }
}
