<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Traveler;

class TravelerController extends Controller
{
    
    //show the traveler registration form

    public function showRegistrationForm()
    {
        return view('traveler.travelerRegister');
    }

    //Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'username' => 'required|string|max:120|unique:users',
            'email' => 'required|email|unique:users',
            'phone_no' => 'required|string|regex:/^[0-9]{10}$/',
            'password' => 'required|string|confirmed|min:6',
            'national_id' => 'required|string|min:10|max:12|unique:travelers,national_id',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'phone_no' => $request->phone_no,
            'password' => Hash::make($request->password),
            'role' => 'Traveler',
        ]);

        Traveler::create([
        'user_id' => $user->id,
        'national_id' => $request->national_id,
        ]);

        return redirect()->route('traveler.travelerLogin')->with('success', 'Registration successful. Please login');
    }



    // Show the traveler login form
    
    public function showLoginForm()
    {
        return view('traveler.travelerLogin');
    }



    // Handle traveler login request
    public function login(Request $request)
    {
        $request->validate([
        'login' => ['required', 'string'], // can be username or email
        'password' => ['required', 'string'],
        ]);

        $login = $request->input('login');
        $password = $request->input('password');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Retrieve user by email or username
        $user = User::where($fieldType, $login)->first();

        if ($user && $user->role === 'Traveler'){

            if (Auth::attempt([$fieldType => $login, 'password' => $password])) {
                $request->session()->regenerate();

                // Redirect to traveler dashboard
                return redirect()->intended(route('traveler.travelerDashboard'));
            }

        }

        throw ValidationException::withMessages([
            'login' => __('Invalid credentials. Please try again.'),
        ]);
    }

    /**
     * Show traveler dashboard
     */
    public function dashboard()
    {
        return view('traveler.travelerDashboard');
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