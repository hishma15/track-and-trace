<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;

class StaffPasswordResetController extends Controller
{
    // Show "Forgot Password" form
    public function showLinkRequestForm()
    {
        return view('staff.auth.forgot-password');
    }

    // Send reset link to email
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user || $user->role !== 'Staff') {
            return back()->with('status', 'If that email exists, a reset link has been sent.');
        }
        $token = Str::random(64);
        // Store plain token (same as Traveler)
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );
        // Generate URL with token + email
        $url = route('staff.password.reset', [
            'token' => $token,
            'email' => $request->email
        ]);
        // Send email
        Mail::send('emails.password-reset', ['url' => $url], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Your Staff Password');
        });

        return back()->with('status', 'If that email exists, a reset link has been sent.');
    }

    // Show "Reset Password" form
    public function showResetForm($token)
    {
        return view('staff.auth.reset-password', ['token' => $token]);
    }

    // Handle password reset
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required'
        ], [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Password is required.',
            'password.confirmed' => 'Password and Confirm Password do not match.',
            'password.min' => 'Password must be at least 6 characters long.',
            'token.required' => 'Invalid reset request. Please use the link from your email.'
        ]);

        $reset = DB::table('password_resets')->where([
            ['email', $request->email],
            ['token', $request->token]
        ])->first();

        if (!$reset) {
            return back()->withErrors(['email' => 'Invalid token or email.']);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user || $user->role !== 'Staff') {
            return back()->withErrors(['email' => 'Invalid user.']);
        }

        // Update password
        $user->update(['password' => Hash::make($request->password)]);

        // Delete reset entry
        DB::table('password_resets')->where(['email' => $request->email])->delete();

        return redirect()->route('staff.staffLogin')->with('success', 'Password has been reset!');
    }
}
