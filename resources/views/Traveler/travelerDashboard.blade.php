<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Track & Trace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Lustria&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">


    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f1e8 0%, #e8dcc6 100%);
        }
        .sidebar-bg {
            background: linear-gradient(180deg, #f5f1e8 0%, #e8dcc6 100%);
        }
        .welcome-card {
            background: linear-gradient(135deg, #8B4513 0%, #654321 100%);
        }
        .profile-card {
            background: linear-gradient(135deg, #f0f8ff 0%, #e6f3ff 100%);
            border: 1px solid #e0e6ed;
        }
        .action-card {
            background: linear-gradient(135deg, #f0f8ff 0%, #e6f3ff 100%);
            border: 1px solid #e0e6ed;
            transition: all 0.3s ease;
        }
        .action-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
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
        .search-box {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }
        .profile-avatar {
            background: linear-gradient(135deg, #87CEEB 0%, #4682B4 100%);
        }
        .train-illustration {
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 200'%3E%3Cg fill='%23f5f1e8'%3E%3Cpath d='M50 140 L350 140 L340 120 L60 120 Z'/%3E%3Ccircle cx='100' cy='160' r='12'/%3E%3Ccircle cx='300' cy='160' r='12'/%3E%3Cpath d='M70 120 L70 100 L330 100 L330 120'/%3E%3Cpath d='M90 100 L90 80 L150 80 L150 100'/%3E%3Cpath d='M250 100 L250 80 L320 80 L320 100'/%3E%3Cpath d='M80 100 L80 85 L140 85 L140 100'/%3E%3Cpath d='M260 100 L260 85 L310 85 L310 100'/%3E%3C/g%3E%3C/svg%3E") no-repeat center right;
            background-size: 200px auto;
        }
    </style>
    

</head>

<body class="min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-72 sidebar-bg shadow-lg">
            <div class="p-6">
                <!-- Logo -->
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center">
                        <img src="{{ asset('images/luggage-icon.png') }}" alt="Logo" class="w-6 h-6">
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">Track N'</h1>
                        <h1 class="text-xl font-bold text-gray-800">Trace</h1>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="space-y-2">
                    <a href="{{ route('traveler.travelerDashboard') }}" class="nav-item active flex items-center gap-3 p-3 rounded-lg text-gray-700 font-medium">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
                        </svg>
                        Dashboard
                    </a>
                    
                    <a href="#" class="nav-item flex items-center gap-3 p-3 rounded-lg text-gray-700 font-medium">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                        Discover
                    </a>
                    
                    <a href="#" class="nav-item flex items-center gap-3 p-3 rounded-lg text-gray-700 font-medium">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                        </svg>
                        Lost Luggage
                    </a>
                    
                    <a href="#" class="nav-item flex items-center gap-3 p-3 rounded-lg text-gray-700 font-medium">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                        Found Luggage
                    </a>
                    
                    <a href="#" class="nav-item flex items-center gap-3 p-3 rounded-lg text-gray-700 font-medium">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
                        </svg>
                        Total Reports
                    </a>
                    
                    <a href="#" class="nav-item flex items-center gap-3 p-3 rounded-lg text-gray-700 font-medium">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                        My Profile
                    </a>
                    
                    <a href="#" class="nav-item flex items-center gap-3 p-3 rounded-lg text-gray-700 font-medium">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19.14,12.94c0.04-0.3,0.06-0.61,0.06-0.94c0-0.32-0.02-0.64-0.07-0.94l2.03-1.58c0.18-0.14,0.23-0.41,0.12-0.61 l-1.92-3.32c-0.12-0.22-0.37-0.29-0.59-0.22l-2.39,0.96c-0.5-0.38-1.03-0.7-1.62-0.94L14.4,2.81c-0.04-0.24-0.24-0.41-0.48-0.41 h-3.84c-0.24,0-0.43,0.17-0.47,0.41L9.25,5.35C8.66,5.59,8.12,5.92,7.63,6.29L5.24,5.33c-0.22-0.08-0.47,0-0.59,0.22L2.74,8.87 C2.62,9.08,2.66,9.34,2.86,9.48l2.03,1.58C4.84,11.36,4.8,11.69,4.8,12s0.02,0.64,0.07,0.94l-2.03,1.58 c-0.18,0.14-0.23,0.41-0.12,0.61l1.92,3.32c0.12,0.22,0.37,0.29,0.59,0.22l2.39-0.96c0.5,0.38,1.03,0.7,1.62,0.94l0.36,2.54 c0.05,0.24,0.24,0.41,0.48,0.41h3.84c0.24,0,0.44-0.17,0.47-0.41l0.36-2.54c0.59-0.24,1.13-0.56,1.62-0.94l2.39,0.96 c0.22,0.08,0.47,0,0.59-0.22l1.92-3.32c0.12-0.22,0.07-0.47-0.12-0.61L19.14,12.94z M12,15.6c-1.98,0-3.6-1.62-3.6-3.6 s1.62-3.6,3.6-3.6s3.6,1.62,3.6,3.6S13.98,15.6,12,15.6z"/>
                        </svg>
                        Settings
                    </a>
                    
                    <a href="#" class="nav-item flex items-center gap-3 p-3 rounded-lg text-gray-700 font-medium">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11 18h2v-2h-2v2zm1-16C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm0-14c-2.21 0-4 1.79-4 4h2c0-1.1.9-2 2-2s2 .9 2 2c0 2-3 1.75-3 5h2c0-2.25 3-2.5 3-5 0-2.21-1.79-4-4-4z"/>
                        </svg>
                        Help & Support
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-hidden">
            <!-- Header -->
            <header class="bg-white/80 backdrop-blur-sm border-b border-gray-200 px-8 py-4">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-semibold text-gray-800">Traveler Dashboard</h1>
                    
                    <div class="flex items-center gap-4">
                        <!-- Search Box -->
                        <div class="relative">
                            <input type="text" 
                                   placeholder="Search..." 
                                   class="search-box pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent w-80">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        
                        <!-- User Profile -->
                        <div class="flex items-center gap-3">
                            <span class="text-gray-700 font-medium">Traveler</span>
                            <div class="profile-avatar w-10 h-10 rounded-full flex items-center justify-center">
                                <div class="w-8 h-8 bg-green-500 rounded-full"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="p-8 h-full overflow-y-auto">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 h-full">
                    <!-- Left Column - Welcome & Actions -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Welcome Card -->
                        <div class="welcome-card rounded-2xl p-8 text-white train-illustration">
                            <div class="max-w-md">
                                <h2 class="text-3xl font-bold mb-2">Welcome to Track N' Trace.</h2>
                                <p class="text-lg mb-6 opacity-90">QR Based Lost Luggage management system</p>
                                
                                <div class="flex gap-4">
                                    <button class="bg-white/20 backdrop-blur-sm px-6 py-3 rounded-lg font-medium hover:bg-white/30 transition">
                                        Reports
                                    </button>
                                    <button class="bg-white/20 backdrop-blur-sm px-6 py-3 rounded-lg font-medium hover:bg-white/30 transition">
                                        Give Feedback
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Report Button -->
                        <div class="flex justify-center">
                            <button class="bg-white/60 backdrop-blur-sm px-8 py-3 rounded-lg font-medium text-gray-700 hover:bg-white/80 transition shadow-md">
                                REPORT
                            </button>
                        </div>

                        <!-- Action Cards -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Register Luggages -->
                            <div class="action-card rounded-2xl p-6 cursor-pointer">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 bg-orange-100 rounded-xl flex items-center justify-center">
                                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-800">Register Luggages</h3>
                                    </div>
                                </div>
                            </div>

                            <!-- Report Lost Luggage -->
                            <div class="action-card rounded-2xl p-6 cursor-pointer">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 bg-teal-100 rounded-xl flex items-center justify-center">
                                        <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.860-.833-2.630 0L3.184 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-800">Report Lost Luggage</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Profile Details -->
                    <div class="lg:col-span-1">
                        <div class="profile-card rounded-2xl p-6 h-full">
                            <h3 class="text-xl font-semibold text-gray-800 mb-6">Profile Details</h3>
                            
                            <!-- Profile Avatar -->
                            <div class="flex justify-center mb-6">
                                <div class="profile-avatar w-24 h-24 rounded-full flex items-center justify-center">
                                    <div class="w-20 h-20 bg-green-500 rounded-full"></div>
                                </div>
                            </div>

                            <!-- Profile Information -->
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-1">First Name:</label>
                                    <div class="text-gray-800 font-medium">{{ auth()->user()->first_name ?? 'John' }}</div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-1">Last Name:</label>
                                    <div class="text-gray-800 font-medium">{{ auth()->user()->last_name ?? 'Doe' }}</div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-1">Email Address:</label>
                                    <div class="text-gray-800 font-medium">{{ auth()->user()->email ?? 'john.doe@example.com' }}</div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-1">Phone Number:</label>
                                    <div class="text-gray-800 font-medium">{{ auth()->user()->phone_no ?? '+1234567890' }}</div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-1">National ID:</label>
                                    <div class="text-gray-800 font-medium">{{ auth()->user()->traveler->national_id ?? '123456789V' }}</div>
                                </div>
                            </div>

                            <!-- Edit Button -->
                            <div class="mt-8 flex justify-center">
                                <a href="#" class="flex items-center gap-2 bg-gray-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-gray-700 transition">
                                    <span>EDIT DETAILS</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>