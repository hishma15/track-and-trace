<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Luggage;
use App\Models\User;
use App\Models\Traveler;
use App\Models\Staff;
use App\Models\Notification;
use App\Models\QRScanLog;
use App\Models\Feedback;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminStatisticsController extends Controller
{
    public function dashboard()
    {
        // Basic counts
        $totalLuggage = Luggage::count();
        $registeredLuggage = Luggage::where('status', 'Safe')->count();
        $lostLuggage = Luggage::where('status', 'lost')->count();
        $foundLuggage = Luggage::where('status', 'Found')->count();
        $totalTravelers = Traveler::count();
        $totalStaff = Staff::count();
        $totalNotifications = Notification::count();
        $totalFeedback = Feedback::count();

        // Resolution rate calculation
        $resolutionRate = $lostLuggage > 0 ? round(($foundLuggage / ($lostLuggage + $foundLuggage)) * 100, 1) : 0;

        // Monthly luggage registration trends (last 12 months)
        $monthlyRegistrations = Luggage::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', Carbon::now()->subYear())
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get()
        ->map(function ($item) {
            return [
                'month' => Carbon::createFromDate($item->year, $item->month, 1)->format('M Y'),
                'count' => $item->count
            ];
        });

        // Lost vs Found trends (last 12 months)
        $lostFoundTrends = DB::table('luggage')
            ->select(
                DB::raw('YEAR(COALESCE(date_lost, date_found, created_at)) as year'),
                DB::raw('MONTH(COALESCE(date_lost, date_found, created_at)) as month'),
                DB::raw('SUM(CASE WHEN status = "lost" THEN 1 ELSE 0 END) as lost_count'),
                DB::raw('SUM(CASE WHEN status = "Found" THEN 1 ELSE 0 END) as found_count')
            )
            ->where(DB::raw('COALESCE(date_lost, date_found, created_at)'), '>=', Carbon::now()->subYear())
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                return [
                    'month' => Carbon::createFromDate($item->year, $item->month, 1)->format('M'),
                    'lost' => $item->lost_count,
                    'found' => $item->found_count
                ];
            });

        // Top lost stations
        $topLostStations = Luggage::select('lost_station', DB::raw('COUNT(*) as count'))
    ->whereRaw('LOWER(status) = "lost"')
    ->whereNotNull('lost_station')
    ->groupBy('lost_station')
    ->orderByDesc('count')
    ->limit(5)
    ->get();




        // Luggage by color statistics
        $luggageByColor = Luggage::select('color', DB::raw('COUNT(*) as count'))
            ->groupBy('color')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        // Recent activity (last 30 days)
        $recentActivity = [
            'new_registrations' => Luggage::where('created_at', '>=', Carbon::now()->subDays(30))->count(),
            'lost_reports' => Luggage::where('date_lost', '>=', Carbon::now()->subDays(30))->count(),
            'found_luggage' => Luggage::where('date_found', '>=', Carbon::now()->subDays(30))->count(),
            'new_travelers' => User::where('role', 'Traveler')
                ->where('created_at', '>=', Carbon::now()->subDays(30))->count(),
        ];

        $staffPerformance = Staff::with('user')
    ->leftJoin('qr_scan_logs', 'staff.id', '=', 'qr_scan_logs.staff_id')
    ->select(
        'staff.id',
        'staff.user_id',
        'staff.organization',
        'staff.position',
        DB::raw('COUNT(qr_scan_logs.id) as total_scans')
    )
    ->where(function ($query) {
        $query->where('qr_scan_logs.scan_datetime', '>=', Carbon::now()->subDays(30))
              ->orWhereNull('qr_scan_logs.scan_datetime');
    })
    ->groupBy('staff.id', 'staff.user_id', 'staff.organization', 'staff.position')
    ->orderByDesc('total_scans')
    ->limit(5)
    ->get();



        // Average resolution time (days from lost to found)
        $avgResolutionTime = Luggage::whereNotNull('date_lost')
            ->whereNotNull('date_found')
            ->selectRaw('AVG(DATEDIFF(date_found, date_lost)) as avg_days')
            ->first();

        $avgResolutionDays = $avgResolutionTime ? round($avgResolutionTime->avg_days, 1) : 0;

        // Feedback statistics
        $feedbackStats = [
            'total' => Feedback::count(),
            'pending' => Feedback::where('status', 'Pending')->count(),
            'avg_rating' => Feedback::avg('rating') ? round(Feedback::avg('rating'), 1) : 0,
            'recent' => Feedback::where('submitted_at', '>=', Carbon::now()->subDays(7))->count()
        ];

        // System growth (user registration over time)
        $userGrowth = User::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as daily_count'),
            DB::raw('SUM(COUNT(*)) OVER (ORDER BY DATE(created_at)) as cumulative_count')
        )
        ->where('created_at', '>=', Carbon::now()->subDays(30))
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy('date')
        ->get();

        return view('admin.statistics', compact(
            'totalLuggage',
            'registeredLuggage',
            'lostLuggage',
            'foundLuggage',
            'totalTravelers',
            'totalStaff',
            'totalNotifications',
            'totalFeedback',
            'resolutionRate',
            'monthlyRegistrations',
            'lostFoundTrends',
            'topLostStations',
            'luggageByColor',
            'recentActivity',
            'staffPerformance',
            'avgResolutionDays',
            'feedbackStats',
            'userGrowth'
        ));
    }

    public function getAdvancedStats(Request $request)
    {
        $period = $request->get('period', '30'); // days
        $startDate = Carbon::now()->subDays($period);

        // Time-based analysis
        $hourlyStats = Luggage::select(
            DB::raw('HOUR(created_at) as hour'),
            DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', $startDate)
        ->groupBy('hour')
        ->orderBy('hour')
        ->get();

        // Brand popularity
        $brandStats = Luggage::select('brand_type', DB::raw('COUNT(*) as count'))
            ->where('created_at', '>=', $startDate)
            ->groupBy('brand_type')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        // Status distribution
        $statusDistribution = Luggage::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        return response()->json([
            'hourly_stats' => $hourlyStats,
            'brand_stats' => $brandStats,
            'status_distribution' => $statusDistribution
        ]);
    }

    public function exportStatistics(Request $request)
    {
        $format = $request->get('format', 'csv');
        
        // Collect all statistics
        $data = [
            'summary' => [
                'total_luggage' => Luggage::count(),
                'lost_luggage' => Luggage::where('status', 'lost')->count(),
                'found_luggage' => Luggage::where('status', 'Found')->count(),
                'total_travelers' => Traveler::count(),
                'total_staff' => Staff::count(),
            ],
            'generated_at' => now()->toDateTimeString()
        ];

        if ($format === 'json') {
            return response()->json($data)
                ->header('Content-Disposition', 'attachment; filename="statistics.json"');
        }

        // For CSV format, flatten the data
        $csvData = [];
        foreach ($data['summary'] as $key => $value) {
            $csvData[] = [
                'metric' => str_replace('_', ' ', ucfirst($key)),
                'value' => $value
            ];
        }

        $csv = "Metric,Value\n";
        foreach ($csvData as $row) {
            $csv .= '"' . $row['metric'] . '","' . $row['value'] . '"' . "\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="statistics.csv"');
    }

    public function getRealtimeUpdates()
    {
        // Real-time statistics for AJAX updates
        return response()->json([
            'total_luggage' => Luggage::count(),
            'lost_luggage' => Luggage::where('status', 'lost')->count(),
            'found_luggage' => Luggage::where('status', 'Found')->count(),
            'recent_activity' => Luggage::where('updated_at', '>=', Carbon::now()->subMinutes(5))->count(),
            'last_updated' => now()->toTimeString()
        ]);
    }
}