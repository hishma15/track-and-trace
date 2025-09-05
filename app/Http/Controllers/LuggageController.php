<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Luggage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Notification;
use App\Models\Staff;


use App\Models\QRCode as QRCodeModel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LuggageController extends Controller
{

    //Register a new Luggage
    public function store(Request $request)
    {
        $request->validate([
            'image_path' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'color' => 'required|string|max:50',
            'brand_type' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'unique_features' => 'nullable|string|max:500',
        ]);

        $travelerId = Auth::user()->traveler->id;

        $path = null;
        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('luggage_images', 'public');
        }

        Luggage::create([
            'traveler_id' => $travelerId,
            'image_path' => $path,
            'color' => $request->color,
            'brand_type' => $request->brand_type,
            'description' => $request->description,
            'unique_features' => $request->unique_features,
            'status' => 'Safe',
        ]);

        return redirect()->route('luggage.index')->with('success', 'Luggage registered successfully!');
    }

    public function index()
    {
        $travelerId = Auth::user()->traveler->id;
        $luggages = Luggage::where('traveler_id', $travelerId)->get();
        return view('traveler.myLuggage', compact('luggages'));
    }

   public function reportlostluggage()
{
    $traveler = Auth::user()->traveler;

    if (!$traveler) {
        abort(403, 'You are not authorized as a traveler.');
    }

    $luggages = Luggage::where('traveler_id', $traveler->id)->get();
    return view('Traveler.reportlostluggage', compact('luggages'));
}

public function show($id)
{
    $luggage = Luggage::findOrFail($id);
    return view('staff.luggageshow', compact('luggage'));
}

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'image_path' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'color' => 'required|string|max:50',
            'brand_type' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'unique_features' => 'nullable|string|max:500',
        ]);

        $luggage = Luggage::findOrFail($id);
        
        // Check if the luggage belongs to the authenticated user
        if ($luggage->traveler_id !== Auth::user()->traveler->id) {
            abort(403, 'Unauthorized action.');
        }

        if ($request->hasFile('image_path')) {
            if ($luggage->image_path) {
                Storage::disk('public')->delete($luggage->image_path);
            }
            $luggage->image_path = $request->file('image_path')->store('luggage_images', 'public');
        }

        $luggage->update([
            'color' => $request->color,
            'brand_type' => $request->brand_type,
            'description' => $request->description,
            'unique_features' => $request->unique_features,
        ]);

        return redirect()->route('luggage.index')->with('success', 'Luggage updated successfully!');
    }
    

    public function markLost(Request $request, Luggage $luggage)
{
    $request->validate([
       'data' => json_encode([
    'traveler_name' => $luggage->traveler->user->first_name,
    'lost_station' => $request->lost_station,
    'traveler_comment' => $request->comment,
]),

    ]);

    // Update luggage
    $luggage->update([
        'lost_station' => $request->lost_station,
        'comment' => $request->comment,
        'date_lost' => $request->date_lost,
        'status' => 'lost'
    ]);

    // Find staff whose organization matches the lost_station
    $staffs = Staff::where('organization', $request->lost_station)->get();

    foreach ($staffs as $staff) {
        // Create a notification record
      
            Notification::create([
    'user_id' => $staff->user_id,
    'luggage_id' => $luggage->id,
    'notification_type' => 'lost_luggage',
    'title' => 'New Lost Luggage Reported',
    'message' => 'A luggage has been reported lost at ' . $request->lost_station,
    'data' => json_encode([
        'traveler_name' => $luggage->traveler->user->first_name,
        'lost_station' => $request->lost_station,
        'traveler_comment' => $request->comment, // <--- add this line
    ]),
    'is_read' => false,
    'is_email_sent' => false,
]);

        // Optional: send email here if you want
        // Mail::to($staff->user->email)->send(new LostLuggageMail($luggage));
    }

    return back()->with('success', 'Luggage reported as lost successfully!');
}


public function staffLostLuggages()
{
    $staff = Auth::user()->staff;

    if (!$staff) {
        abort(403, 'Unauthorized.'); // in case a non-staff tries
    }

    // Fetch lost luggages for the staff's organization
    $lostLuggages = Luggage::where('status', 'lost')
        ->where('lost_station', $staff->organization)
        ->get();

    return view('staff.lost_luggages', compact('lostLuggages'));
}

   public function cancelReport(Luggage $luggage)
    {
        $luggage->update([
            'status' => 'Safe', // or whatever status means not lost
            'lost_station' => null,
            'comment' => null,
            'date_lost' => null,
        ]);

        return redirect()->back()->with('success', 'Lost report cancelled successfully.');
    }

   public function cancelLostReport(Luggage $luggage)
{
    // Optionally validate ownership or permissions here

    $luggage->markAsSafe();

    return redirect()->back()->with('success', 'Lost report canceled, luggage marked as safe.');
}



public function lostLuggage()
{
    // Fetch all luggage where status is 'lost'
    $luggages = Luggage::where('status', 'lost')->get();

    // Pass it to the view
    return view('Traveler.lostluggage', compact('luggages'));

    return view('Traveler.lostluggage_reports', compact('luggages'));
}

public function lostLuggageReports()
{
    // Fetch all luggage marked as lost
    $luggages = Luggage::where('status', 'lost')->get();

    // Return the reports view
    return view('Traveler.lostluggage_reports', compact('luggages'));
}

    
    public function destroy($id)
    {
        $luggage = Luggage::findOrFail($id);

        // Optional: Delete image from storage
        if ($luggage->image_path && Storage::exists('public/' . $luggage->image_path)) {
            Storage::delete('public/' . $luggage->image_path);
        }

        $luggage->delete();

        return redirect()->back()->with('success', 'Luggage deleted successfully.');
    }  


/**
 * Generate QR Code as SVG with unique code display
 */
public function generateQrCode($id)
{
    try {
        $luggage = Luggage::findOrFail($id);
        
        if ($luggage->traveler_id !== Auth::user()->traveler->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        
        // Check if QR already exists
        $existingQr = QRCodeModel::where('luggage_id', $luggage->id)->first();
        if ($existingQr) {
            return response()->json([
                'success' => true,
                'qr_svg' => $existingQr->qr_code_data,
                'tracking_url' => $existingQr->qr_image_path,
                'unique_code' => $existingQr->unique_code
            ]);
        }
        
        // Generate unique code first
        $uniqueCode = QRCodeModel::generateUniqueCode();
        
        // Create tracking URL
        $trackingUrl = url('/track/' . $luggage->id);
        
        // Generate QR code as SVG
        $qrSvg = QrCode::format('svg')->size(300)->generate($trackingUrl);
        
        // Save to database
        $qrCodeRecord = QRCodeModel::create([
            'luggage_id' => $luggage->id,
            'qr_code_data' => $qrSvg,
            'qr_image_path' => $trackingUrl,
            'unique_code' => $uniqueCode,
            'is_active' => true,
            'date_created' => now(),
        ]);
        
        return response()->json([
            'success' => true,
            'qr_svg' => $qrSvg,
            'tracking_url' => $trackingUrl,
            'unique_code' => $uniqueCode
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to generate QR code: ' . $e->getMessage()
        ], 500);
    }
}


    /**
     * Download QR Code (will be handled by frontend JS)
     */
    public function downloadQrCode($id)
    {
        try {
            $luggage = Luggage::findOrFail($id);
            
            if ($luggage->traveler_id !== Auth::user()->traveler->id) {
                abort(403, 'Unauthorized action.');
            }

            $qrCode = QRCodeModel::where('luggage_id', $luggage->id)->first();
            
            if (!$qrCode) {
                return redirect()->back()->with('error', 'QR code not found. Please generate it first.');
            }

            // Return the SVG for frontend processing
            return response()->json([
                'success' => true,
                'qr_svg' => $qrCode->qr_code_data,
                'filename' => 'luggage_qr_' . $luggage->id . '.png'
            ]);
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to download QR code.');
        }
    }




public function manualLookup($unique_code)
{
    $qrCode = QRCodeModel::where('unique_code', strtolower(trim($unique_code)))
        ->with(['luggage.traveler.user'])
        ->first();

    if (!$qrCode || !$qrCode->luggage) {
        return response()->json([
            'success' => false,
            'message' => 'Luggage not found'
        ]);
    }

    $luggage = $qrCode->luggage;

    // Prepare luggage data with proper image path
    $luggageData = [
        'id' => $luggage->id,
        'color' => $luggage->color,
        'brand_type' => $luggage->brand_type,
        'description' => $luggage->description,
        'unique_features' => $luggage->unique_features,
        'status' => $luggage->status,
        'lost_station' => $luggage->lost_station,
        'comment' => $luggage->comment,
        'unique_code' => $qrCode->unique_code,
        'date_lost' => $luggage->date_lost ? $luggage->date_lost->format('Y-m-d H:i:s') : null,
        'date_found' => $luggage->date_found ? $luggage->date_found->format('Y-m-d H:i:s') : null,
        'image_path' => $luggage->image_path ? asset('storage/' . $luggage->image_path) : null
    ];

    // Prepare traveler data
    $travelerData = [
        'first_name' => $luggage->traveler->user->first_name ?? '',
        'last_name' => $luggage->traveler->user->last_name ?? '',
        'email' => $luggage->traveler->user->email ?? '',
        'phone_no' => $luggage->traveler->user->phone_no ?? '',
        'national_id' => $luggage->traveler->national_id ?? ''
    ];

    return response()->json([
        'success' => true,
        'luggage' => [
            'luggage' => $luggageData,
            'traveler' => $travelerData
        ]
    ]);
}



    
/**
 * Show manual luggage lookup page
 */
public function showManualLookup()
{
    $staff = Auth::user()->staff;
    
    if (!$staff) {
        abort(403, 'Unauthorized. Staff access required.');
    }
    
    return view('staff.manual-luggage-lookup');
}

/**
 * API endpoint to lookup luggage by unique code
 */
public function lookupByUniqueCode($uniqueCode)
{
    try {
        $qrCode = QRCodeModel::where('unique_code', strtolower(trim($uniqueCode)))
            ->with(['luggage.traveler.user'])
            ->first();
        
        if (!$qrCode || !$qrCode->luggage) {
            return response()->json([
                'success' => false,
                'message' => 'No luggage found with this unique code. Please verify the code and try again.'
            ], 404);
        }
        
        $luggage = $qrCode->luggage;
        
        // Prepare traveler data
        $travelerData = [
            'first_name' => $luggage->traveler->user->first_name ?? '',
            'last_name' => $luggage->traveler->user->last_name ?? '',
            'email' => $luggage->traveler->user->email ?? '',
            'phone_no' => $luggage->traveler->user->phone_no ?? '',
            'national_id' => $luggage->traveler->national_id ?? ''
        ];
        
        // Prepare luggage data
        $luggageData = [
            'id' => $luggage->id,
            'color' => $luggage->color,
            'brand_type' => $luggage->brand_type,
            'description' => $luggage->description,
            'unique_features' => $luggage->unique_features,
            'status' => $luggage->status,
            'lost_station' => $luggage->lost_station,
            'comment' => $luggage->comment,
            'unique_code' => $qrCode->unique_code, // Get from QR code table
            'date_lost' => $luggage->date_lost ? $luggage->date_lost->format('Y-m-d H:i:s') : null,
            'date_found' => $luggage->date_found ? $luggage->date_found->format('Y-m-d H:i:s') : null,
            'image_path' => $luggage->image_path ? asset('storage/' . $luggage->image_path) : null
        ];
        
        return response()->json([
            'success' => true,
            'message' => 'Luggage found successfully',
            'luggage' => $luggageData,
            'traveler' => $travelerData
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Luggage lookup error: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while looking up the luggage. Please try again.'
        ], 500);
    }
}

/**
 * Mark luggage as found via manual lookup
 */
public function markAsFoundManual(Request $request, $id)
{
    try {
        $staff = Auth::user()->staff;
        
        if (!$staff) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Staff access required.'
            ], 403);
        }
        
        $request->validate([
            'location' => 'required|string|max:255',
            'comment' => 'nullable|string|max:500'
        ]);
        
        $luggage = Luggage::findOrFail($id);
        
        // Update luggage status
        $luggage->update([
            'status' => 'Found',
            'date_found' => now(),
            'comment' => $request->comment
        ]);
        
        // Create notification for the traveler
        Notification::create([
            'user_id' => $luggage->traveler->user_id,
            'luggage_id' => $luggage->id,
            'notification_type' => 'luggage_found',
            'title' => 'Your Luggage Has Been Found!',
            'message' => 'Great news! Your luggage has been found at ' . $request->location,
            'data' => json_encode([
                'staff_name' => $staff->user->first_name . ' ' . $staff->user->last_name,
                'found_location' => $request->location,
                'staff_comment' => $request->comment,
                'found_date' => now()->format('Y-m-d H:i:s'),
                'staff_organization' => $staff->organization
            ]),
            'is_read' => false,
            'is_email_sent' => false,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Luggage successfully marked as found. The owner has been notified.'
        ]);
        
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Validation failed: ' . implode(', ', $e->validator->errors()->all())
        ], 422);
        
    } catch (\Exception $e) {
        \Log::error('Mark found manual error: ' . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while updating the luggage status. Please try again.'
        ], 500);
    }
}


}
