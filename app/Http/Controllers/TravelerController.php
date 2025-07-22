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
        ], 
        [    
            'username.unique' => 'This username is already taken.',
            'email.unique' => 'This email is already registered.',
            'phone_no.regex' => 'Phone number must be exactly 10 digits. [format- 0xxxxxxxxx]',
            'password.min' => 'Password must be at least 6 characters.',
            'password.confirmed' => 'Passwords do not match.',
            'national_id.unique' => 'This National ID is already registered.',
            'national_id.min' => 'National ID must be in the format xxxxxxxxxV or xxxxxxxxxxxx.',


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

         // Handle if user doesn't exist
        if (!$user) {
            throw ValidationException::withMessages([
                'login' => 'No account found with these credentials.',
            ]);
        }

        // Handle role mismatch
        if ($user->role !== 'Traveler') {
            throw ValidationException::withMessages([
                'login' => 'You are not authorized to login here. Please use the correct portal for your role.',
            ]);
        }

        // Handle incorrect password
        if (!Auth::attempt([$fieldType => $login, 'password' => $password])) {
            throw ValidationException::withMessages([
                'login' => 'Incorrect password. Please try again.',
            ]);
        }
        // Success
        $request->session()->regenerate();
        return redirect()->intended(route('traveler.travelerDashboard'))->with('success', 'Login successful');
    }

    /**
     * Show traveler dashboard
     */
    public function dashboard()
    {
        return view('traveler.travelerDashboard');
    }

    // Show traveler profile form (with password change popup in view)
    public function showProfileForm()
    {
        $user = auth()->user();
        $traveler = $user->traveler;
        return view('traveler.travelerProfile', compact('user', 'traveler'));
    }

    // Update profile details (excluding email, national_id)
    public function updateProfile(Request $request)
    {

        $user = auth()->user();

        // Validate the form input
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'username' => 'required|string|max:120|unique:users,username,' . $user->id,
            'phone_no' => 'required|string|regex:/^[0-9]{10}$/',
        ], 
        [    
            'username.unique' => 'This username is already taken.',
            'phone_no.regex' => 'Phone number must be exactly 10 digits. [format- 0xxxxxxxxx]',


        ]);

        // Update user details
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->phone_no = $request->phone_no;
        $user->save();

        return redirect()->route('traveler.profile.show')->with('success', 'Profile updated successfully!');
    }

    //Handle password update (via AJAX or form submit)
    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'new_password.confirmed' => 'New password and confirmation do not match.',
            'new_password.min' => 'New password must be at least 6 characters.',
        ]);

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('traveler.profile.show')->with('success', 'Password changed successfully!');
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

    //to delete the account permentantly
    public function destroy(Request $request)
    {
        $user = Auth::user();
        Auth::logout();
        $user->delete();

        return redirect('/')->with('success', 'Your account has been deleted.');
    }

}