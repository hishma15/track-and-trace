<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;

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

        if (Auth::attempt([$fieldType => $login, 'password' => $password])) {
            $request->session()->regenerate();
            return redirect()->intended(route('staff.staffDashboard'));
        }

        throw ValidationException::withMessages([
            'login' => 'Invalid credentials. Please try again.',
        ]);
    }

     // Show traveler profile form (with password change popup in view)
    public function showProfileForm()
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
        return view('staff.staffDashboard');

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
}
