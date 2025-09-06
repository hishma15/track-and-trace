<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Staff;
use App\Models\Luggage;
use App\Models\Traveler;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use App\Models\Feedback;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    /**
     * Show main admin dashboard with quick stats
     */
    public function showDashboard()
    {
        // Quick dashboard statistics
        $quickStats = [
            'total_luggage' => Luggage::count(),
            'lost_luggage' => Luggage::where('status', 'lost')->count(),
            'found_luggage' => Luggage::where('status', 'Found')->count(),
            'total_staff' => Staff::count(),
            'total_travelers' => Traveler::count(),
            'recent_registrations' => Luggage::where('created_at', '>=', Carbon::now()->subDays(7))->count(),
            'recent_lost_reports' => Luggage::where('date_lost', '>=', Carbon::now()->subDays(7))->count(),
            'pending_cases' => Luggage::where('status', 'lost')->count(),
        ];

        // Recent activity
        $recentLuggage = Luggage::with(['traveler.user'])
            ->latest()
            ->limit(5)
            ->get();

        // Staff list for main dashboard
        $staff = Staff::with('user')->latest()->limit(10)->get();

        return view('admin.adminDashboard', compact('quickStats', 'recentLuggage', 'staff'));
    }

    public function manageStaff()
    {
        $staffMembers = User::where('role', 'staff')->get();
        return view('admin.manageStaff', compact('staffMembers'));
    }

    /**
     * Show the staff registration form (only for admin).
     */
    public function showStaffRegistrationForm()
    {
        return view('staff.staffRegister');
    }

    /**
     * Register a staff member (admin only).
     */
   public function registerStaff(Request $request)
{
    $validated = $request->validate([
        'first_name' => 'required|string|max:100',
        'last_name' => 'required|string|max:100',
        'email' => 'required|email|unique:users',
        'username' => 'required|string|max:120|unique:users',
        'phone_no' => 'required|string|regex:/^[0-9]{10}$/',
        'password' => 'required|string|min:6|confirmed',
        'organization' => 'nullable|string|max:255',
        'position' => 'nullable|string|max:255',
        'staff_official_id' => 'required|string|unique:staff,staff_official_id',
    ],
    [
        'username.unique' => 'This username is already taken.',
            'email.unique' => 'This email is already registered.',
            'phone_no.regex' => 'Phone number must be exactly 10 digits. [format- 0xxxxxxxxx]',
            'password.min' => 'Password must be at least 6 characters.',
            'password.confirmed' => 'Passwords do not match.',
            'staff_official_id.unique' => 'This Staff ID is already taken. Please try again with another Staff ID',

    ]);

    try {
        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'phone_no' => $validated['phone_no'],
            'password' => Hash::make($validated['password']),
            'role' => 'Staff',
        ]);
    } catch (\Exception $e) {
        return back()->withErrors(['user_create_error' => 'User creation failed: ' . $e->getMessage()]);
    }

    try {
        $staff = Staff::create([
            'user_id' => $user->id,
            'organization' => $validated['organization'] ?? null,
            'position' => $validated['position'] ?? null,
            'staff_official_id' => $validated['staff_official_id'],
        ]);
    } catch (\Exception $e) {
        // Delete user to avoid orphan if staff creation fails
        $user->delete();
        return back()->withErrors(['staff_create_error' => 'Staff creation failed: ' . $e->getMessage()]);
    }

    return redirect()->route('admin.adminDashboard')->with('success', 'Staff created successfully!');
}

    public function updateProfile(Request $request, $id)
{
    $staff = Staff::findOrFail($id);
    $user = $staff->user;

    $request->validate([
        'first_name' => 'required|string|max:100',
        'last_name' => 'required|string|max:100',
        'phone_no' => 'required|string|regex:/^[0-9]{10}$/',
        'staff_official_id' => 'required|string|unique:staff,staff_official_id,' . $staff->id,
    ],
    [
        'username.unique' => 'This username is already taken.',
        'phone_no.regex' => 'Phone number must be exactly 10 digits. [format- 0xxxxxxxxx]',
    ]);

    $user->first_name = $request->first_name;
    $user->last_name = $request->last_name;
    $user->phone_no = $request->phone_no;
    $user->save();

    $staff->organization = $request->organization;
    $staff->position = $request->position;
    $staff->staff_official_id = $request->staff_official_id;
    $staff->save();

    return back()->with('success', 'Profile updated successfully!');
}

public function updatePassword(Request $request, $id)
{
    $staff = Staff::findOrFail($id);
    $user = $staff->user;

    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|string|min:6|confirmed',
    ], [
        'new_password.confirmed' => 'New password and confirmation do not match.',
        'new_password.min' => 'New password must be at least 6 characters.',
    ]);

    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Current password is incorrect.'])->withInput();
    }

    $user->password = Hash::make($request->new_password);
    $user->save();

    return redirect()->route('admin.staff.profile.show', $staff->id)->with('password_success', 'Password changed successfully!');
}

public function staffList()
{
    $staff = Staff::all();
    return view('admin.adminDashboard', compact('staff'));
}

public function showStaff($id)
{
    $staff = Staff::with('user')->findOrFail($id);
    return view('admin.staffprofile', compact('staff'));
}

public function destroy($staffId)
{
    $staff = Staff::with('user')->findOrFail($staffId);

    $staff->user->delete();
    $staff->delete();

    return redirect()->route('admin.adminDashboard')->with('success', 'Staff profile deleted successfully.');
}

    public function resetPassword(Request $request, $id)
{
    $request->validate([
        'new_password' => 'required|string|min:6|confirmed',
    ], [
        'new_password.confirmed' => 'New password and confirmation do not match.',
        'new_password.min' => 'New password must be at least 6 characters.',
    ]);

    $staff = Staff::findOrFail($id);
    $user = $staff->user;

    $user->password = Hash::make($request->new_password);
    $user->save();

    return redirect()->route('admin.staff.profile.show', $staff->id)
                     ->with('password_success', 'Password has been reset successfully!');
}

    /**
     * Get dashboard statistics for AJAX updates
     */
    public function getDashboardStats()
    {
        $stats = [
            'total_luggage' => Luggage::count(),
            'lost_luggage' => Luggage::where('status', 'lost')->count(),
            'found_luggage' => Luggage::where('status', 'Found')->count(),
            'resolution_rate' => $this->calculateResolutionRate(),
            'recent_activity' => Luggage::where('updated_at', '>=', Carbon::now()->subHours(24))->count(),
            'last_updated' => now()->format('H:i:s')
        ];

        return response()->json($stats);
    }

    /**
     * Helper method to calculate resolution rate
     */
    private function calculateResolutionRate()
    {
        $lostCount = Luggage::where('status', 'lost')->count();
        $foundCount = Luggage::where('status', 'Found')->count();
        
        if ($lostCount + $foundCount == 0) {
            return 0;
        }
        
        return round(($foundCount / ($lostCount + $foundCount)) * 100, 1);
    }

    /**
     * System health check
     */
    public function systemHealth()
    {
        $health = [
            'database' => $this->checkDatabaseHealth(),
            'storage' => $this->checkStorageHealth(),
            'performance' => $this->checkPerformanceMetrics(),
            'last_checked' => now()->toDateTimeString()
        ];

        return response()->json($health);
    }

    private function checkDatabaseHealth()
    {
        try {
            $userCount = User::count();
            return ['status' => 'healthy', 'users' => $userCount];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Database connection failed'];
        }
    }

    private function checkStorageHealth()
    {
        try {
            $diskSpace = disk_free_space(storage_path());
            return ['status' => 'healthy', 'free_space' => $this->formatBytes($diskSpace)];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Storage check failed'];
        }
    }

    private function checkPerformanceMetrics()
    {
        $start = microtime(true);
        User::count(); // Simple query to test performance
        $queryTime = (microtime(true) - $start) * 1000;

        return [
            'query_time' => round($queryTime, 2) . 'ms',
            'memory_usage' => $this->formatBytes(memory_get_usage()),
            'peak_memory' => $this->formatBytes(memory_get_peak_usage())
        ];
    }

    private function formatBytes($size, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        
        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }
        
        return round($size, $precision) . ' ' . $units[$i];
    }

    /**
     * Show all users for admin
     */
    public function viewUsers()
    {
        $users = User::all();
        return view('admin.users', compact('users')); // 👈 updated to match your file
    }


    /**
     * Show all feedback to admin
     */
    public function viewFeedback()
    {
        $feedbacks = Feedback::with('traveler.user')->get(); // eager load traveler->user
        return view('admin.feedback', compact('feedbacks'));
    }

    /**
     * Respond to feedback via email
     */
    public function respondFeedback(Request $request, $id)
{
    $feedback = Feedback::findOrFail($id);
    $userEmail = $feedback->traveler->user->email;

    $message = $request->message ?? "Hello Traveler, 

    Thank you for reaching out to us through the feedback form. 
    We truly appreciate your input and will take your suggestions into account to improve the Track & Trace system.

    Best regards,  
    Track & Trace Support Team";

    Mail::raw($message, function ($mail) use ($userEmail) {
        $mail->to($userEmail)
             ->subject("Response to your feedback from Track & Trace");
    });

    // feedback status and admin response
    $feedback->update([
        'status' => 'Responded',
        'admin_response' => $message,
        'responded_at' => now(),
    ]);

    return redirect()->back()->with('success', 'Feedback response sent successfully!');
}

}