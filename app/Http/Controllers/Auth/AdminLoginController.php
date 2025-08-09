<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

            $request->session()->regenerate();

            return redirect()->route('admin.adminDashboard');
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
        if (Auth::check() && Auth::user()->role === 'Admin') {
            return view('admin.adminDashboard');
        }

        return redirect()->route('admin.login')->withErrors(['login' => 'Unauthorized access']);
    }
    
}
