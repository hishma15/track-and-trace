<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TravelerController extends Controller
{
    
    //show the traveler registration form

    public function showRegistrationForm()
    {
        return view('traveler.travelerRegister');
    }



    // Show the traveler login form
    
    public function showLoginForm()
    {
        return view('traveler.travelerLogin');
    }

    // Handle traveler login request
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // You can add additional logic here for traveler-specific authentication
        // For example, checking if the user has a 'traveler' role
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect to traveler dashboard or appropriate page
            return redirect()->intended('/traveler/dashboard');
        }

        throw ValidationException::withMessages([
            'username' => __('The provided credentials do not match our records.'),
        ]);
    }

    /**
     * Show traveler dashboard
     */
    public function dashboard()
    {
        return view('traveler.dashboard');
    }



    /**
     * Handle traveler logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('traveler.travelerLogin');
    }
}