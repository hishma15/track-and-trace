<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    //
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ], [
            'rating.required' => 'Please rate us by selecting the star rating.',
        ]);


        $feedback = Feedback::create([
            'traveler_id' => auth()->user()->traveler->id,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'status' => 'Pending',
            'admin_response' => null,
            'submitted_at' => now(),
            'rating' => $validated['rating'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Thank you for your feedback!');
    }

    public function create()
{
    return view('traveler.travelerDashboard'); 
}

}
