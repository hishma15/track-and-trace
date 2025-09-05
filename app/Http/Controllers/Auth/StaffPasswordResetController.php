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
    //
    //
    public function showLinkRequestForm()
    {
        return view('staff.auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user || $user->role !== 'Staff') {
            return back()->with('status', 'Check your email inbox for a password reset link. Click the link to set a new password. If you don’t see it, check your spam folder');
        }

        $token = Str::random(64);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => Carbon::now()]
        );

        // Mail::send('emails.password-reset', ['token' => $token], function ($message) use ($request) {
        //     $message->to($request->email);
        //     $message->subject('Reset Your Traveler Password');
        // });

        $url = route('staff.password.reset', ['token' => $token]);

        Mail::send('emails.password-reset', ['url' => $url], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Your Staff Password');
        });


        return back()->with('status', 'If that email exists, a reset link has been sent.');
    }

    public function showResetForm($token)
    {
        return view('staff.auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required'
        ]);

        $reset = DB::table('password_resets')->where([
            ['email', $request->email],
            ['token', $request->token]
        ])->first();

        if (!$reset) {
            return back()->withErrors(['email' => 'Invalid token or email.']);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user || $user->role !== 'Traveler') {
            return back()->withErrors(['email' => 'Invalid user.']);
        }

        $user->update(['password' => Hash::make($request->password)]);
        DB::table('password_resets')->where(['email' => $request->email])->delete();

        return redirect()->route('staff.staffLogin')->with('success', 'Password has been reset!');
    }
}
