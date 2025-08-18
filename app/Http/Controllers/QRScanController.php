<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Luggage;
use App\Models\QRScanLog;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class QRScanController extends Controller
{
    /**
     * Show QR scanner page for staff
     */
    // public function showScanner()
    // {
    //     // Ensure only staff can access this page
    //     if (!Auth::user() || !Auth::user()->staff) {
    //         abort(403, 'Unauthorized access. Staff only.');
    //     }
        
    //     return view('staff.qr-scanner');
    // }

    /**
     * Get luggage details by ID (for QR scanning)
     */
    public function getLuggageDetails($luggageId)
    {
        try {
            // Ensure only staff can access this endpoint
            if (!Auth::user() || !Auth::user()->staff) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            $luggage = Luggage::with(['traveler.user'])->find($luggageId);
            
            if (!$luggage) {
                return response()->json([
                    'success' => false,
                    'message' => 'Luggage not found'
                ], 404);
            }

            // Log the scan attempt
            QRScanLog::create([
                'staff_id' => Auth::user()->staff->id,
                'luggage_id' => $luggage->id,
                'action' => 'scan_attempt',
                'scan_datetime' => now(),
                'scan_location' => request()->ip(), // You can enhance this with actual location
            ]);

            return response()->json([
                'success' => true,
                'luggage' => [
                    'id' => $luggage->id,
                    'color' => $luggage->color,
                    'brand_type' => $luggage->brand_type,
                    'description' => $luggage->description,
                    'unique_features' => $luggage->unique_features,
                    'status' => $luggage->status,
                    'image_path' => $luggage->image_path ? asset('storage/' . $luggage->image_path) : null,
                    'date_registered' => $luggage->date_registered,
                    'date_lost' => $luggage->date_lost,
                    'lost_station' => $luggage->lost_station,
                ],
                'traveler' => [
                    'first_name' => $luggage->traveler->user->first_name,
                    'last_name' => $luggage->traveler->user->last_name,
                    'phone_no' => $luggage->traveler->user->phone_no,
                    'email' => $luggage->traveler->user->email,
                    'national_id' => $luggage->traveler->national_id,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving luggage details: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mark luggage as found
     */
    public function markAsFound(Request $request, $luggageId)
    {
        try {
            // Ensure only staff can access this endpoint
            if (!Auth::user() || !Auth::user()->staff) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            $request->validate([
                'comment' => 'nullable|string|max:500',
                'location' => 'nullable|string|max:255',
            ]);

            $luggage = Luggage::find($luggageId);
            
            if (!$luggage) {
                return response()->json([
                    'success' => false,
                    'message' => 'Luggage not found'
                ], 404);
            }

            // Check if luggage is already found
            if ($luggage->status === 'Found') {
                return response()->json([
                    'success' => false,
                    'message' => 'Luggage is already marked as found'
                ], 400);
            }

            DB::transaction(function () use ($luggage, $request) {
                // Mark luggage as found
                $luggage->markAsFound(true);

                // Log the scan action
                QRScanLog::create([
                    'staff_id' => Auth::user()->staff->id,
                    'luggage_id' => $luggage->id,
                    'action' => 'mark_found',
                    'comment' => $request->comment,
                    'scan_location' => $request->location ?? request()->ip(),
                    'scan_datetime' => now(),
                ]);

                // Create notification for traveler
                Notification::create([
                    'user_id' => $luggage->traveler->user->id,
                    'luggage_id' => $luggage->id,
                    'notification_type' => 'found_luggage',
                    'title' => 'Great News! Your Luggage Has Been Found',
                    'message' => "Your {$luggage->color} {$luggage->brand_type} luggage has been found by our staff. Please contact us to arrange collection.",
                    'is_read' => false,
                    'sent_at' => now(),
                ]);

                // You can add email notification here
                // Mail::to($luggage->traveler->user->email)->send(new LuggageFoundMail($luggage));
            });

            return response()->json([
                'success' => true,
                'message' => 'Luggage successfully marked as found. Owner has been notified.',
                'luggage' => [
                    'id' => $luggage->id,
                    'status' => $luggage->status,
                    'date_found' => $luggage->date_found->format('Y-m-d H:i:s'),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error marking luggage as found: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get scan history for a specific luggage
     */
    public function getScanHistory($luggageId)
    {
        try {
            if (!Auth::user() || !Auth::user()->staff) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            $luggage = Luggage::find($luggageId);
            
            if (!$luggage) {
                return response()->json([
                    'success' => false,
                    'message' => 'Luggage not found'
                ], 404);
            }

            $scanLogs = QRScanLog::where('luggage_id', $luggageId)
                ->with('staff.user')
                ->orderBy('scan_datetime', 'desc')
                ->get()
                ->map(function ($log) {
                    return [
                        'id' => $log->id,
                        'action' => $log->action,
                        'comment' => $log->comment,
                        'scan_location' => $log->scan_location,
                        'scan_datetime' => $log->scan_datetime->format('Y-m-d H:i:s'),
                        'staff' => [
                            'name' => $log->staff->user->first_name . ' ' . $log->staff->user->last_name,
                            'email' => $log->staff->user->email,
                        ]
                    ];
                });

            return response()->json([
                'success' => true,
                'scan_logs' => $scanLogs
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving scan history: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get staff dashboard stats
     */
    public function getStaffStats()
    {
        try {
            if (!Auth::user() || !Auth::user()->staff) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access'
                ], 403);
            }

            $staffId = Auth::user()->staff->id;
            $today = now()->startOfDay();

            $stats = [
                'total_scans_today' => QRScanLog::where('staff_id', $staffId)
                    ->whereDate('scan_datetime', $today)
                    ->count(),
                
                'total_found_today' => QRScanLog::where('staff_id', $staffId)
                    ->where('action', 'mark_found')
                    ->whereDate('scan_datetime', $today)
                    ->count(),
                
                'total_lost_luggage' => Luggage::where('status', 'Lost')->count(),
                
                'total_found_luggage' => Luggage::where('status', 'Found')->count(),
                
                'recent_scans' => QRScanLog::where('staff_id', $staffId)
                    ->with(['luggage', 'staff.user'])
                    ->orderBy('scan_datetime', 'desc')
                    ->take(5)
                    ->get()
                    ->map(function ($log) {
                        return [
                            'luggage_id' => $log->luggage_id,
                            'action' => $log->action,
                            'scan_datetime' => $log->scan_datetime->diffForHumans(),
                            'luggage_color' => $log->luggage->color ?? 'Unknown',
                            'luggage_brand' => $log->luggage->brand_type ?? 'Unknown',
                        ];
                    })
            ];

            return response()->json([
                'success' => true,
                'stats' => $stats
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving stats: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Public tracking page (for QR code links)
     * This page will check if user is authorized staff or show unauthorized message
     */
    public function trackLuggage($luggageId)
    {
        try {
            $luggage = Luggage::with(['traveler.user'])->find($luggageId);
            
            if (!$luggage) {
                return view('public.luggage-not-found', ['luggage_id' => $luggageId]);
            }

            // Check if user is authenticated and is staff
            if (Auth::check() && Auth::user()->staff) {
                // User is authorized staff - redirect to scanner with luggage pre-loaded
                return redirect()->route('staff.qr-scanner', ['luggage_id' => $luggageId])
                    ->with('auto_load_luggage', true);
            } else {
                // User is not authorized staff - show unauthorized page
                return view('public.unauthorized-access', [
                    'luggage_id' => $luggageId,
                    'luggage_color' => $luggage->color,
                    'luggage_brand' => $luggage->brand_type,
                    'status' => $luggage->status
                ]);
            }

        } catch (\Exception $e) {
            return view('public.tracking-error', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Show QR scanner page for staff with optional luggage pre-loading
     */
    public function showScanner(Request $request)
    {
        // Ensure only staff can access this page
        if (!Auth::user() || !Auth::user()->staff) {
            abort(403, 'Unauthorized access. Staff only.');
        }
        
        $autoLoadLuggage = $request->get('luggage_id') && $request->session()->get('auto_load_luggage');
        
        
        return view('staff.qr-scanner', [
            'auto_load_luggage_id' => $autoLoadLuggage ? $request->get('luggage_id') : null
        ]);
    }

    /**
     * Log unauthorized access attempts for security monitoring
     */
    public function logUnauthorizedAccess(Request $request)
    {
        try {
            $request->validate([
                'luggage_id' => 'required|string|max:50',
                'timestamp' => 'required|string',
                'user_agent' => 'nullable|string|max:500',
            ]);

            // Log the unauthorized access attempt
            \Log::warning('Unauthorized QR code access attempt', [
                'luggage_id' => $request->luggage_id,
                'timestamp' => $request->timestamp,
                'ip_address' => $request->ip(),
                'user_agent' => $request->user_agent,
                'referer' => $request->header('referer'),
            ]);

            // You can also store this in a dedicated table for security monitoring
            // UnauthorizedAccess::create([...]);

            return response()->json([
                'success' => true,
                'message' => 'Access attempt logged'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Logging failed'
            ], 500);
        }
    }
}