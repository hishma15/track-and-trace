<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

use App\Models\User;
use App\Models\Staff;

use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    //
        
    //show the traveler registration form

    public function showStaffRegistrationForm()
    {
        return view('staff.staffRegister');
    }


    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'username' => 'required|string|max:120|unique:users',
            'email' => 'required|email|unique:users',
            'phone_no' => 'required|string|max:10',
            'password' => 'required|string|min:6|confirmed',
            'organization' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'staff_official_id' => 'required|string|unique:staff,staff_official_id',
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'phone_no' => $validated['phone_no'],
            'password' => Hash::make($validated['password']),
            'role' => 'Staff',
        ]);

        Staff::create([
            'user_id' => $user->id,
            'organization' => $validated['organization'] ?? null,
            'position' => $validated['position'] ?? null,
            'staff_official_id' => $validated['staff_official_id'],
            'approval_status' => 'pending',
        ]);

        return redirect()->route('staff.staffLogin')->with('message', 'Registration successful! Please wait for admin approval.');
}


        // Show the traveler login form
    
    public function showStaffLoginForm()
    {
        return view('staff.staffLogin');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => ['required', 'string'], // username or email
            'password' => ['required', 'string'],
        ]);

        $login = $request->input('login');
        $password = $request->input('password');
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $user = User::where($fieldType, $login)->first();

        if ($user && $user->role === 'Staff') {
            $staff = $user->staff;

            if (!$staff) {
                throw ValidationException::withMessages([
                    'login' => 'Staff profile not found.',
                ]);
            }

            if ($staff->approval_status === 'pending') {
                throw ValidationException::withMessages([
                    'login' => 'Your staff account is pending admin approval.',
                ]);
            }

            if ($staff->approval_status === 'rejected') {
                throw ValidationException::withMessages([
                    'login' => 'Your staff registration has been rejected.',
                ]);
            }

            if (Auth::attempt([$fieldType => $login, 'password' => $password])) {
                $request->session()->regenerate();
                return redirect()->intended(route('staff.staffDashboard'));
            }
        }

        throw ValidationException::withMessages([
            'login' => 'Invalid credentials or unapproved account. Please try again',
        ]);
        
    }

    /**
     * Staff dashboard
     */
    public function dashboard()
    {
        return view('staff.staffDashboard');
    }
    
    /**
    * Staff logout
    */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('staff.staffLogin');
    }


}
