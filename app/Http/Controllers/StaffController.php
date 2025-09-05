<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

use App\Models\User;
use App\Models\Staff;

use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class StaffController extends Controller
{
    /**
     * Show the staff login form.
     */
    public function showStaffLoginForm()
    {
        return view('staff.staffLogin');
    }

    /**
     * Handle staff login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $login = $request->input('login');
        $password = $request->input('password');
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $user = User::where($fieldType, $login)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'login' => 'No account found with provided credentials.',
            ]);
        }

        if ($user->role !== 'Staff') {
            throw ValidationException::withMessages([
                'login' => 'Only staff members can log in from this portal.',
            ]);
        }

        // if (Auth::attempt([$fieldType => $login, 'password' => $password])) {
        //     $request->session()->regenerate();
        //     return redirect()->intended(route('staff.staffDashboard'));
        // }

        if (Auth::attempt([$fieldType => $login, 'password' => $password])) {
            $user = Auth::user();
            $staff = $user->staff;

            if ($staff->two_factor_enabled) {
                // Generate OTP
                $otp = rand(100000, 999999);
                $user->update([
                    'otp_code' => $otp,
                    'otp_expires_at' => Carbon::now()->addMinutes(5),
                    'is_otp_verified' => false,
                ]);

                Mail::raw("Your new OTP is: $otp", function($message) use ($user) {
                    $message->to($user->email)->subject('Your Staff OTP');
                });

                return redirect()->route('staff.verify-otp')
                    ->with('status', 'OTP sent to your email.');
            }

            // If 2FA is disabled → login directly
            $request->session()->regenerate();
            return redirect()->intended(route('staff.staffDashboard'))
                ->with('success', 'Login successful');
        }

    }


    public function toggle2FA(Request $request)
{
    $staff = Auth::user()->staff;

    if (!$staff) {
        return back()->withErrors(['error' => 'Staff profile not found.']);
    }

    // Toggle 2FA
    $staff->two_factor_enabled = !$staff->two_factor_enabled;
    $staff->save();

    return back()->with('success', $staff->two_factor_enabled
        ? 'Two-factor authentication enabled.'
        : 'Two-factor authentication disabled.');
}



     // Show traveler profile form (with password change popup in view)
    public function showProfileForm()
    {
        $user = auth()->user();
        $staff = $user->staff;
        return view('staff.staffprofile', compact('user', 'staff'));
    }

       public function showProfiledetails()
    {
        $user = auth()->user();
        $staff = $user->staff;
        return view('staff.staffprofile', compact('user', 'staff'));
    }
    /**
     * Staff dashboard.
     */
    public function dashboard()
    {
        if (Auth::check() && Auth::user()->role === 'Staff' && Auth::user()->is_otp_verified){
            return view('staff.staffDashboard');
        }
        
        return redirect()->route('staff.otp.verify')->withErrors(['otp' => 'Please verify OTP first.']);

    }

public function notifications()
{
    // Fetch all notifications for the logged-in staff
    $notifications = auth()->user()->notifications()
        ->whereHas('luggage', function($query) {
            $query->where('status', 'lost'); // Only fetch notifications for lost luggage
        })
        ->latest()
        ->get();

    return view('staff.notification', [
        'notifications' => $notifications,
        'active' => 'notifications'
    ]);
}


    public function manualLookup($unique_code)
{
    $luggage = Luggage::with('traveler')
                ->where('unique_code', $unique_code)
                ->first();

    if (!$luggage) {
        return response()->json(['success' => false, 'message' => 'Luggage not found']);
    }

    return response()->json([
        'success' => true,
        'luggage' => [
            'luggage' => $luggage,
            'traveler' => $luggage->traveler
        ]
    ]);
}





    /**
     * Staff logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing')->with('success', 'You have been logged out.');
    }




    public function showOtpForm()
    {
        return view('staff.verifyOtp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);

        $user = Auth::user();

        if ($user->otp_code == $request->otp && $user->otp_expires_at->isFuture()) {
            $user->update(['is_otp_verified' => true]);
            return redirect()->route('staff.staffDashboard')->with('success', 'OTP verified successfully.');
        }

        return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
    }

    public function resendOtp()
    {
        $user = Auth::user();

        // Only allow if user is an admin
        if ($user->role !== 'Staff') {
            Auth::logout();
            return redirect()->route('staff.staffLogin')->withErrors(['login' => 'Unauthorized']);
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

        return redirect()->route('staff.verify-otp')
            ->with('status', 'A new OTP has been sent to your email.');
    }

}
