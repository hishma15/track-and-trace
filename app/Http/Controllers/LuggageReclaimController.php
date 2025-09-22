<?php

namespace App\Http\Controllers;

use App\Models\Luggage;
use App\Models\LuggageReclaim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;

class LuggageReclaimController extends Controller
{
    /**
     * Show reclaim form for a specific luggage
     */
    public function showReclaimForm($luggageId)
    {
        $luggage = Luggage::findOrFail($luggageId);
        return view('staff.reclaim_luggage', compact('luggage'));
    }

    /**
     * Handle reclaim request: save collector details + send OTP with T&C
     */
    public function sendOtpForReclaim(Request $request, $luggageId)
{
    $request->validate([
        'collector_name' => 'required|string',
        'collector_id_type' => 'required|string',
        'collector_id_number' => 'required|string',
        'collector_contact' => 'nullable|string',
        'relationship' => 'nullable|string',
    ]);

    $luggage = Luggage::findOrFail($luggageId);
    $traveler = $luggage->traveler;          // Traveler model
    $travelerUser = $traveler->user;         // Parent User (has email)

    // Generate OTP
    $otp = rand(100000, 999999);

    // Save reclaim request
    $reclaim = LuggageReclaim::create([
        'luggage_id' => $luggage->id,
        'traveler_id' => $traveler->id,
        'user_id' => Auth::id(),              // logged-in staff
        'collector_name' => $request->collector_name,
        'collector_id_type' => $request->collector_id_type,
        'collector_id_number' => $request->collector_id_number,
        'collector_contact' => $request->collector_contact,
        'relationship' => $request->relationship,
        'otp_code' => $otp,
    ]);

    // Send OTP email
    Mail::raw("
Dear {$travelerUser->first_name},

We have received a request to reclaim your luggage (ID: {$luggage->id}) at {$luggage->found_station}.

Terms & Conditions:
1. I confirm that this luggage belongs to me (or I am an authorized representative).
2. I accept that once the luggage is reclaimed, the station is not responsible for future claims.
3. I agree to provide the OTP below to the staff member only if I accept these terms.

Your One-Time Password (OTP): {$otp}

⚠️ Please share this OTP only with the staff member handling your luggage reclaim.

Thank you,  
Track & Trace Team
    ", function ($message) use ($travelerUser) {
        $message->to($travelerUser->email)    // send to parent user email
                ->subject('Luggage Reclaim Request - Terms & OTP');
    });

    return redirect()->route('staff.verify-reclaim-otp-form', $reclaim->id)
        ->with('status', 'OTP has been sent to the traveler with terms & conditions.');
}

    /**
     * Show OTP input form for staff
     */
    public function showVerifyOtpForm($reclaimId)
    {
        $reclaim = LuggageReclaim::findOrFail($reclaimId);
        return view('partials.reclaim_otp', compact('reclaim'));
    }

    /**
     * Verify OTP and finalize reclaim
     */
//     public function verifyReclaimOtp(Request $request, $reclaimId)
//     {
//         $request->validate(['otp' => 'required|numeric']);

//         $reclaim = LuggageReclaim::findOrFail($reclaimId);
//         $travelerUser = $reclaim->traveler->user;

//         if ($reclaim->otp_code == $request->otp && !$reclaim->otp_verified) {
//             // Mark OTP as verified
//             $reclaim->update([
//                 'otp_verified' => true,
//                 'reclaimed_at' => Carbon::now(),
//             ]);

//             // Update luggage status → safe
//             $reclaim->luggage->update(['status' => 'safe']);

//             // Send confirmation mail
//             Mail::raw("
// Dear {$travelerUser->first_name},

// Your luggage (ID: {$reclaim->luggage->id}) has been successfully reclaimed.

// Collector: {$reclaim->collector_name}  
// Collector {$reclaim->collector_id_type} : {$reclaim->collector_id_number}  
// Handled By: {$staffFirstName} {$staffLastName} ({$staffOrganization})
// Date: {$reclaim->reclaimed_at->format('Y-m-d H:i')}  

// Your luggage status has been updated to Safe ✅

// ⚠️ Track and Trace will not hold any responsibilty about this luggage as it has been successfully reclaimed. 

// Thank you for using Track & Trace.
// ", function ($message) use ($travelerUser) {
//                 $message->to($travelerUser->email)
//                         ->subject('Luggage Successfully Reclaimed');
//             });

//             return redirect()->route('staff.lost_luggages')
//                 ->with('success', 'OTP verified. Luggage marked as Safe.');
//         }

//         return back()->withErrors(['otp' => 'Invalid or already used OTP.']);
//     }

public function verifyReclaimOtp(Request $request, $reclaimId)
{
    $request->validate(['otp' => 'required|numeric']);

    $reclaim = LuggageReclaim::findOrFail($reclaimId);
    $travelerUser = $reclaim->traveler->user;

    if ($reclaim->otp_code == $request->otp && !$reclaim->otp_verified) {
        // Mark OTP as verified
        $reclaim->update([
            'otp_verified' => true,
            'reclaimed_at' => Carbon::now(),
        ]);

        // Update luggage status → safe
        $reclaim->luggage->update(['status' => 'safe']);

        // ✅ Get staff details
        $staffUser = Auth::user();
        $staffFirstName = $staffUser->first_name ?? 'Unknown';
        $staffLastName = $staffUser->last_name ?? '';
        $staffOrganization = $staffUser->staff->organization ?? 'N/A';

        // Send confirmation mail
        Mail::raw("
Dear {$travelerUser->first_name},

Your luggage (ID: {$reclaim->luggage->id}) has been successfully reclaimed.

Collector: {$reclaim->collector_name}  
Collector {$reclaim->collector_id_type}: {$reclaim->collector_id_number}  
Handled By: {$staffFirstName} {$staffLastName} ({$staffOrganization})  
Date: {$reclaim->reclaimed_at->format('Y-m-d H:i')}  

Your luggage status has been updated to Safe ✅

⚠️ Track & Trace will not be responsible for this luggage going forward.

Thank you for using Track & Trace.
", function ($message) use ($travelerUser) {
            $message->to($travelerUser->email)
                    ->subject('Luggage Successfully Reclaimed');
        });

        return redirect()->route('staff.reports')
        ->with('success', 'OTP verified. Luggage marked as Safe and added to reports.');
    }

    return back()->withErrors(['otp' => 'Invalid or already used OTP.']);
}


    /**
     * Resend OTP for an existing reclaim request
     */
    public function resendReclaimOtp($reclaimId)
    {
        $reclaim = LuggageReclaim::findOrFail($reclaimId);
        $travelerUser = $reclaim->traveler->user;

        $otp = rand(100000, 999999);

        $reclaim->update([
            'otp_code' => $otp,
            'otp_verified' => false,
            'otp_sent_at' => Carbon::now(),
        ]);

        // Send new OTP
        Mail::raw("
Dear {$travelerUser->first_name},

This is a resend of the OTP for reclaiming your luggage (ID: {$reclaim->luggage->id}) at {$reclaim->luggage->found_station}.

Terms & Conditions:
1. I confirm that this luggage belongs to me (or I am an authorized representative).
2. I accept that once the luggage is reclaimed, the station and airline are not responsible for future claims.
3. I agree to provide the OTP below to the staff member only if I accept these terms.

Your new OTP: {$otp}

⚠️ Please share this OTP only with the staff member handling your luggage reclaim.

Thank you,  
Track & Trace Team
", function ($message) use ($travelerUser) {
            $message->to($travelerUser->email)
                    ->subject('Resend: Luggage Reclaim OTP & Terms');
        });

        return back()->with('status', 'A new OTP has been sent to the traveler.');
    }


    public function staffReports()
{
    $user = Auth::user();

    // Get the logged-in staff's station (organization)
    $organization = $user->staff->organization ?? null;

    // Fetch only reclaimed luggage for staff in the same organization
    $reclaims = LuggageReclaim::whereHas('user.staff', function ($query) use ($organization) {
            $query->where('organization', $organization);
        })
        ->whereNotNull('reclaimed_at') // ✅ Only show reclaimed luggage
        ->with(['luggage', 'traveler.user', 'user.staff'])
        ->orderByDesc('reclaimed_at') // ✅ Order by reclaim time
        ->get();

    return view('staff.reports', compact('reclaims', 'organization'));
}

public function adminReclaims()
{
    // Fetch only luggage that has been actually reclaimed (otp verified + reclaimed_at set)
    $reclaims = LuggageReclaim::whereNotNull('reclaimed_at')
        ->where('otp_verified', true)
        ->with(['luggage', 'traveler.user', 'user.staff'])
        ->orderByDesc('reclaimed_at')
        ->get();

    return view('admin.reclaims', compact('reclaims'));
}


}
