<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Track & Trace - Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Lustria&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!--Icons from fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Alpine JS  -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        .nav-item {
            transition: all 0.3s ease;
        }
        .nav-item:hover {
            background: rgba(139, 69, 19, 0.1);
            transform: translateX(5px);
        }
        .nav-item.active {
            background: rgba(139, 69, 19, 0.15);
            border-right: 3px solid #8B4513;
        }
        .station-card:hover {
            transform: translateY(-2px);
        }
        .report-item:hover {
            transform: translateX(5px);
        }

        /* ----------------------------------------------- */

        .stats-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.stats-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.stats-icon {
    transition: all 0.3s ease;
}

.stats-card:hover .stats-icon {
    transform: scale(1.1);
}

.chart-container {
    position: relative;
    height: 300px;
    margin-bottom: 20px;
}

.loading-spinner {
    border: 4px solid #f3f4f6;
    border-top: 4px solid #3b82f6;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
    margin: 0 auto;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.progress-bar {
    background: linear-gradient(90deg, #10b981 0%, #34d399 100%);
    height: 8px;
    border-radius: 4px;
    overflow: hidden;
    position: relative;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.1) 100%);
    animation: progress-shimmer 2s infinite;
}

@keyframes progress-shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

.metric-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
    line-height: 1;
}

.metric-badge.success {
    background-color: #dcfce7;
    color: #166534;
}

.metric-badge.warning {
    background-color: #fef3c7;
    color: #92400e;
}

.metric-badge.danger {
    background-color: #fecaca;
    color: #991b1b;
}

.metric-badge.info {
    background-color: #dbeafe;
    color: #1e40af;
}

.trend-indicator {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.875rem;
    font-weight: 500;
}

.trend-up {
    color: #059669;
}

.trend-down {
    color: #dc2626;
}

.trend-neutral {
    color: #6b7280;
}

/* Chart styling */
.chart-legend {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-top: 1rem;
    flex-wrap: wrap;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #6b7280;
}

.legend-color {
    width: 12px;
    height: 12px;
    border-radius: 2px;
}

/* Responsive design improvements */
@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .chart-container {
        height: 250px;
    }
    
    .mobile-scroll {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    .mobile-scroll table {
        min-width: 600px;
    }
}

/* Export buttons styling */
.export-buttons {
    display: flex;
    gap: 0.5rem;
}

.export-button {
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    font-weight: 500;
    transition: all 0.2s;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.export-button:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Animation for counters */
.counter {
    transition: all 0.5s ease-out;
}

.counter.animate {
    animation: countUp 1.5s ease-out;
}

@keyframes countUp {
    from {
        transform: scale(0.8);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}

/* Custom scrollbar for tables */
.custom-scrollbar::-webkit-scrollbar {
    height: 8px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Status indicators */
.status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
    margin-right: 0.5rem;
}

.status-dot.active {
    background-color: #10b981;
    animation: pulse 2s infinite;
}

.status-dot.inactive {
    background-color: #6b7280;
}

.status-dot.warning {
    background-color: #f59e0b;
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

    </style>
</head>

<body class="min-h-screen" style="background-image: url('/images/backgroundimg.jpeg'); background-size: cover; background-position: center;">

    <div class="flex min-h-screen">
        
    <!-- Sidebar -->
    @include('partials.admin-sidebar', ['active' => 'discover'])

    <div class="container mx-1">

    <!-- Header -->
    <div class="mb-8 bg-white/80 backdrop-blur-sm border-b border-gray-200 px-8 py-4">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Admin Dashboard</h1>
                <p class="text-gray-600 mt-2">Comprehensive overview of your Track N' Trace system</p>
            </div>
            <div class="flex gap-3">
                <select id="periodFilter" class="px-4 py-2 border rounded-lg">
                    <option value="30">Last 30 days</option>
                    <option value="90">Last 3 months</option>
                    <option value="365">Last year</option>
                </select>
                <button onclick="exportStats('csv')" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700"> <i class="fas fa-download mr-2"></i>
                    Export CSV
                </button>
                <button onclick="exportStats('json')" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700"> <i class="fas fa-download mr-2"></i>
                    Export JSON
                </button>
            </div>
        </div>
    </div>

     <!-- Success Message -->
            @if (session('success'))
                <div class="mx-8 mt-4 bg-green-100 text-green-700 border border-green-300 p-3 rounded mb-4 text-center">
                    {{ session('success') }}
                </div>
            @endif

    <!-- Main Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <div class="bg-[#edede1] rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Luggage</p>
                    <p class="text-3xl font-bold text-blue-600">{{ number_format($totalLuggage) }}</p>
                </div>
                <div class="bg-blue-200 p-3 rounded-full">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-suitcase-rolling text-white text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-green-500 text-sm font-medium">{{ $recentActivity['new_registrations'] }}</span>
                <span class="text-gray-500 text-sm"> new this month</span>
            </div>
        </div>

        <div class="bg-[#edede1] rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Lost Luggage</p>
                    <p class="text-3xl font-bold text-red-600">{{ number_format($lostLuggage) }}</p>
                </div>
                <div class="bg-red-200 p-3 rounded-full">
                    <div class="w-16 h-16 bg-gradient-to-br from-red-400 to-red-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-search text-white text-xl"></i>
                            </div>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-red-500 text-sm font-medium">{{ $recentActivity['lost_reports'] }}</span>
                <span class="text-gray-500 text-sm"> reported this month</span>
            </div>
        </div>

        <div class="bg-[#edede1] rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Found Luggage</p>
                    <p class="text-3xl font-bold text-green-600">{{ number_format($foundLuggage) }}</p>
                </div>
                <div class="bg-green-200 p-3 rounded-full">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-check-double text-white text-xl"></i>
                            </div>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-green-500 text-sm font-medium">{{ $recentActivity['found_luggage'] }}</span>
                <span class="text-gray-500 text-sm"> found this month</span>
            </div>
        </div>

        <div class="bg-[#edede1] rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Resolution Rate</p>
                    <p class="text-3xl font-bold text-purple-600">{{ $resolutionRate }}%</p>
                </div>
                <div class="bg-purple-200 p-3 rounded-full">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-chart-line text-white text-xl"></i>
                            </div>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-purple-500 text-sm font-medium">{{ $avgResolutionDays }} days</span>
                <span class="text-gray-500 text-sm"> avg resolution time</span>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Lost vs Found Trends Chart -->
        <div class="bg-[#edede1] rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Lost vs Found Trends</h3>
            <canvas id="lostFoundChart" width="400" height="200"></canvas>
        </div>

        <!-- Resolution Rate Circle -->
        <div class="bg-[#edede1] rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Resolution Performance</h3>
            <div class="flex items-center justify-center h-48">
                <div class="relative">
                    <svg class="w-32 h-32 transform -rotate-90">
                        <circle cx="64" cy="64" r="52" stroke="#e5e7eb" stroke-width="8" fill="none"></circle>
                        <circle cx="64" cy="64" r="52" stroke="#10b981" stroke-width="8" fill="none" 
                                stroke-dasharray="326" stroke-dashoffset="{{ 326 - (326 * $resolutionRate / 100) }}"
                                class="transition-all duration-1000 ease-out"></circle>
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="text-2xl font-bold text-gray-800">{{ $resolutionRate }}%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Statistics -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Top Lost Stations -->
        <div class="bg-[#edede1] rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Top Lost Stations</h3>
            <div class="space-y-3">
                @foreach($topLostStations as $station)
                <div class="flex justify-between items-center">
                    <span class="text-gray-700">{{ $station->lost_station ?: 'Unknown' }}</span>
                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-sm font-medium">
                        {{ $station->count }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Luggage by Color -->
        <div class="bg-[#edede1] rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Popular Luggage Colors</h3>
            <div class="space-y-3">
                @foreach($luggageByColor as $color)
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <div class="w-4 h-4 rounded-full mr-2" 
                             style="background-color: {{ strtolower($color->color) === 'black' ? '#000000' : (strtolower($color->color) === 'red' ? '#ef4444' : (strtolower($color->color) === 'blue' ? '#3b82f6' : '#6b7280')) }}"></div>
                        <span class="text-gray-700">{{ $color->color }}</span>
                    </div>
                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm font-medium">
                        {{ $color->count }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- System Overview -->
        <div class="bg-[#edede1] rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">System Overview</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Total Travelers</span>
                    <span class="font-semibold text-gray-800">{{ number_format($totalTravelers) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Active Staff</span>
                    <span class="font-semibold text-gray-800">{{ number_format($totalStaff) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Total Notifications</span>
                    <span class="font-semibold text-gray-800">{{ number_format($totalNotifications) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Feedback Received</span>
                    <span class="font-semibold text-gray-800">{{ number_format($feedbackStats['total']) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Avg Rating</span>
                    <div class="flex items-center">
                        <span class="font-semibold text-gray-800 mr-1">{{ $feedbackStats['avg_rating'] }}</span>
                        <div class="flex text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $feedbackStats['avg_rating'])
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 text-gray-300" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Staff Performance Table -->
    @if($staffPerformance->count() > 0)
    <div class="bg-[#edede1] rounded-lg shadow-md p-6 mb-8">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Staff Performance (Last 30 Days)</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Staff Member</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Organization</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Scans</th>
                    </tr>
                </thead>
                <tbody class="bg-[#edede1] divide-y divide-gray-200">
                    @foreach($staffPerformance as $staff)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $staff->user->first_name }} {{ $staff->user->last_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $staff->organization ?: 'Not assigned' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $staff->position ?: 'Not specified' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $staff->total_scans }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Monthly Registration Chart -->
    <div class="bg-[#edede1] rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Monthly Luggage Registrations</h3>
        <canvas id="monthlyChart" width="400" height="100"></canvas>
    </div>
</div>

    </div>
    <footer class="bg-gray-100 border-t py-6 text-center text-sm text-gray-600">
        <div class="max-w-7xl mx-auto px-4">
            <p>&copy; {{ date('Y') }} Track & Trace · Sri Lanka Railways. All rights reserved.</p>
            <div class="mt-2 flex justify-center gap-4 text-gray-500">
                <a href="#" class="hover:text-blue-600 transition">Help & Support</a>
                <a href="#" class="hover:text-blue-600 transition">About Us</a>
                <a href="mailto:support@trackntrace.com" class="hover:text-blue-600 transition">Contact</a>
            </div>
        </div>
    </footer>



    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

    // Auto-hide success messages
    setTimeout(() => {
        const alert = document.querySelector('.bg-green-100');
        if (alert) {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => {
            alert.remove();
            }, 500);
        }
    }, 3000);

    // Lost vs Found Trends Chart
    const lostFoundCtx = document.getElementById('lostFoundChart').getContext('2d');
    const lostFoundChart = new Chart(lostFoundCtx, {
        type: 'bar',
        data: {
            labels: [
                @foreach($lostFoundTrends as $trend)
                    '{{ $trend["month"] }}',
                @endforeach
            ],
            datasets: [{
                label: 'Lost',
                data: [
                    @foreach($lostFoundTrends as $trend)
                        {{ $trend["lost"] }},
                    @endforeach
                ],
                backgroundColor: 'rgba(239, 68, 68, 0.8)',
                borderColor: 'rgba(239, 68, 68, 1)',
                borderWidth: 1
            }, {
                label: 'Found',
                data: [
                    @foreach($lostFoundTrends as $trend)
                        {{ $trend["found"] }},
                    @endforeach
                ],
                backgroundColor: 'rgba(16, 185, 129, 0.8)',
                borderColor: 'rgba(16, 185, 129, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Monthly Registration Chart
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyChart = new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: [
                @foreach($monthlyRegistrations as $reg)
                    '{{ $reg["month"] }}',
                @endforeach
            ],
            datasets: [{
                label: 'Registrations',
                data: [
                    @foreach($monthlyRegistrations as $reg)
                        {{ $reg["count"] }},
                    @endforeach
                ],
                borderColor: 'rgba(59, 130, 246, 1)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Export functions
    function exportStats(format) {
        window.location.href = `/admin/statistics/export?format=${format}`;
    }

    // Real-time updates
    setInterval(function() {
        fetch('/admin/statistics/realtime')
            .then(response => response.json())
            .then(data => {
                // Update dashboard with real-time data if needed
                console.log('Real-time update:', data);
            });
    }, 30000); // Update every 30 seconds
    </script>

    
</body>
</html>