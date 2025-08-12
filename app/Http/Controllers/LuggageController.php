<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Luggage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
    

    public function markLost(Request $request, Luggage $luggage)
{
    $validated = $request->validate([
        'lost_station' => 'required|string|max:255',
        'comment' => 'required|string',
        'date_lost' => 'required|date',
    ]);

    $luggage->update([
        'status' => 'Lost',
        'lost_station' => $validated['lost_station'],
        'comment' => $validated['comment'],
        'date_lost' => $validated['date_lost'],  // save user-provided date/time
    ]);

    return redirect()->back()->with('success', 'Luggage marked as lost successfully.');
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
}
