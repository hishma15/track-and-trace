<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Luggage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $travelerId = Auth::user()->traveler->id;
        $luggages = Luggage::where('traveler_id', $travelerId)->get();
        return view('Traveler.reportlostluggage',compact('luggages'));
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
     * Generate QR Code as SVG - No ImageMagick needed!
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
                    'tracking_url' => $existingQr->qr_image_path // We'll store the URL here
                ]);
            }

            // Create tracking URL
            $trackingUrl = url('/track/' . $luggage->id);
            
            // Generate QR code as SVG
            $qrSvg = QrCode::format('svg')->size(300)->generate($trackingUrl);
            
            // Save to database (store SVG in qr_code_data, URL in qr_image_path)
            QRCodeModel::create([
                'luggage_id' => $luggage->id,
                'qr_code_data' => $qrSvg, // Store SVG here
                'qr_image_path' => $trackingUrl, 
                'is_active' => true,
                'date_created' => now(),
            ]);

            return response()->json([
                'success' => true,
                'qr_svg' => $qrSvg,
                'tracking_url' => $trackingUrl
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


}
