<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Staff;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
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
        'phone_no' => 'required|string|max:10',
        'password' => 'required|string|min:6|confirmed',
        'organization' => 'nullable|string|max:255',
        'position' => 'nullable|string|max:255',
        'staff_official_id' => 'required|string|unique:staff,staff_official_id',
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
        'phone_no' => 'required|string|max:10',
        'staff_official_id' => 'required|string|unique:staff,staff_official_id,' . $staff->id,
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
 // or load user by $id if different

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

    return redirect()->route('admin.adminDashboard')->with('password_success', 'Password changed successfully!');

}




public function staffList()
{
    $staff = Staff::all(); // fetch all staff
    return view('admin.adminDashboard', compact('staff'));
}

public function showStaff($id)
{
    $staff = Staff::with('user')->findOrFail($id);
    return view('admin.staffprofile', compact('staff'));
}

    public function showDashboard()
{
    // Fetch all staff with user info
    $staff = Staff::with('user')->get();

    return view('admin.adminDashboard', compact('staff'));
}

public function destroy($staffId)
{
    $staff = Staff::with('user')->findOrFail($staffId);

    $staff->user->delete();
    $staff->delete();

    return redirect()->route('admin.adminDashboard')->with('success', 'Staff profile deleted successfully.');
}


}
