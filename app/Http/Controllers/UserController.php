<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Http\Request;
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
        $request->session()->flush();
        return redirect()->route('LoginPage');
    }



    function SendOTP(Request $request)
    {
        $email = $request->input('email');
        $otp = rand(1000, 9999);
        $count = User::where('email', '=', $email)->count();
        if ($count == 1) {
            Mail::to($email)->send(new OTPMail($otp));
            User::where('email', '=', $email)->update(['otp' => $otp]);
            $data = ['message' => 'Request Successful', 'status' => true, 'error' => ''];
            $request->session()->put('email', $email);
            return  redirect()->route('VerifyOTPPage')->with($data);
        } else {
            $data = ['message' => 'Request Successful', 'status' => false, 'error' => ''];
            return  redirect()->route('SendOTPPage')->with($data);
        }
    }


    function verifyOTP(Request $request)
    {
        $email = $request->session()->get('email', 'default');
        $otp = $request->input('otp');
        $count = User::where('email', '=', $email)
            ->where('otp', '=', $otp)->count();

        if ($count == 1) {
            User::where('email', '=', $email)->update(['otp' => '0']);
            $request->session()->put('otp_verify', 'yes');
            $data = ['message' => 'OTP Verify Successful', 'status' => true, 'error' => ''];
            return  redirect()->route('ResetPasswordPage')->with($data);
        } else {
            $data = ['message' => 'OTP Verify Failed', 'status' => false, 'error' => ''];
            return  redirect()->route('SendOTPPage')->with($data);
        }
    }


    function ResetPassword(Request $request)
    {
        try {
            $email = $request->session()->get('email');
            $otp_verify = $request->session()->get('otp_verify');
            $password = $request->input('password');

            if ($otp_verify === "yes" && $email) {
                User::where('email', $email)->update([
                    'password' => Hash::make($password)
                ]);

                // Only clear reset-related session data
                $request->session()->forget(['email', 'otp_verify']);

                return redirect()
                    ->route('Login')
                    ->with(['message' => 'Password reset successful', 'status' => true]);
            } else {
                return redirect()
                    ->route('Login')
                    ->with(['message' => 'Invalid or expired reset request', 'status' => false]);
            }
        } catch (Exception $e) {
            return redirect()
                ->route('ResetPasswordPage')
                ->with(['message' => 'Password reset failed', 'status' => false, 'error' => $e->getMessage()]);
        }
    }

    function UpdateProfile(Request $request)
    {
        try {
            $email = $request->input('email');
            $name = $request->input('name');
            $mobile = $request->input('mobile');
            $password = $request->input('password');

            $updateData = [
                'name' => $name,
                'email' => $email,
                'mobile' => $mobile
            ];

            // Only update password if provided
            if (!empty($password)) {
                $updateData['password'] = Hash::make($password);
            }

            User::where('email', '=', $email)->update($updateData);

            $data = ['message' => 'Profile Updated Successfully', 'status' => true];
            return redirect()->route('Profile')->with($data);
        } catch (Exception $e) {
            $data = ['message' => 'Request Fail', 'status' => false, 'error' => $e->getMessage()];
            return redirect()->route('Profile')->with($data);
        }
    }
}
