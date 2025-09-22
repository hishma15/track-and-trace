<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    //
     public function showAdminLoginForm()
    {
        return view('admin.adminLogin');
    }

    //ADMIN LOGIN
    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            if (Auth::user()->role !== 'Admin') {
                Auth::logout();
                return back()->withErrors(['login' => 'Unauthorized. You are not an admin.']);
            }
            // Generate OTP
            $otp = rand(100000, 999999);
            $user = Auth::user();
            $user->update([
                'otp_code' => $otp,
                'otp_expires_at' => Carbon::now()->addMinutes(5),
                'is_otp_verified' => false,
            ]);
            // Send OTP via Email (or SMS)
            Mail::raw("Your OTP is: $otp", function($message) use ($user) {
                $message->to($user->email)->subject('Your Admin OTP');
            });
            // Redirect to OTP verification page
            return redirect()->route('admin.verify-otp')->with('status', 'OTP sent to your email.');
        }
        return back()->withErrors(['login' => 'Invalid credentials.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing')->with('success', 'You have been logged out.');
    }

    public function showDashboard()
    {
        if (Auth::check() && Auth::user()->role === 'Admin' && Auth::user()->is_otp_verified) {
            return view('admin.adminDashboard');
        }
        return redirect()->route('admin.otp.verify')->withErrors(['otp' => 'Please verify OTP first.']);
    }



    
    public function showOtpForm()
    {
        return view('admin.verifyOtp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);

        $user = Auth::user();

        if ($user->otp_code == $request->otp && $user->otp_expires_at->isFuture()) {
            $user->update(['is_otp_verified' => true]);
            return redirect()->route('admin.adminDashboard')->with('success', 'OTP verified successfully.');
        }

        return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
    }

    public function resendOtp()
    {
        $user = Auth::user();

        // Only allow if user is an admin
        if ($user->role !== 'Admin') {
            Auth::logout();
            return redirect()->route('admin.adminLogin')->withErrors(['login' => 'Unauthorized']);
        }

        // Generate new OTP
        $otp = rand(100000, 999999);

        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(5),
            'is_otp_verified' => false,
        ]);

        // Send OTP via email (or log it)
        Mail::raw("Your new OTP is: $otp", function($message) use ($user) {
            $message->to($user->email)->subject('Your Admin OTP');
        });

        return redirect()->route('admin.verify-otp')
            ->with('status', 'A new OTP has been sent to your email.');
    }

    
}
