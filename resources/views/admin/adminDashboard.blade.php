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
    </style>
</head>

<body class="min-h-screen" style="background-image: url('/images/backgroundimg.jpeg'); background-size: cover; background-position: center;">
    <div class="flex min-h-screen">
        
        <!-- Sidebar -->
        @include('partials.admin-sidebar', ['active' => 'dashboard'])


        <!-- Main Content -->
        <main class="flex-1 overflow-hidden">
            <!-- Header -->
            <header class="bg-white/80 backdrop-blur-sm border-b border-gray-200 px-8 py-4">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-semibold text-[#55372c]">Admin Dashboard</h1>
                    

                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="p-8 overflow-y-auto">

             <!-- Success Message -->
            @if (session('success'))
                <div class="mx-8 mt-4 bg-green-100 text-green-700 border border-green-300 p-3 rounded mb-4 text-center">
                    {{ session('success') }}
                </div>
            @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 h-full">
                    <!-- Left Column - Welcome & Station Cards -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Welcome Card -->
                        <div class="rounded-2xl p-8 bg-[#55372c] bg-gradient-to-r from-[#7a4f3f] to-[#55372c] text-[#edede1]">
                            <div class="max-w-md">
                                <h2 class="text-3xl font-bold mb-2">Welcome to Track N' Trace.</h2>
                                <p class="text-lg mb-6 opacity-90">QR Based Lost Luggage management system</p>
                                
                                <div class="flex gap-4">
                                    <a href="#" class="bg-white/20 backdrop-blur-sm px-6 py-3 rounded-lg font-medium hover:bg-white/30 transition">
                                        Reports
                                    </a>
                                   <button
                                            id="openRegisterStaffModalBtn"
                                            class="bg-white/20 backdrop-blur-sm px-6 py-3 rounded-lg font-medium hover:bg-white/30 transition"
                                            type="button"
                                        >
                                            Manage Staff
                                        </button>

@include('partials.register-staff-modal')


                                </div>
                            </div>
                            <!-- Train illustration -->
                            <div class="absolute right-4 top-1/2 transform -translate-y-1/2 opacity-30">
                                <i class="fas fa-train text-6xl"></i>
                            </div>
                        </div>

                        <!-- Staff List Button -->
                        <div class="flex justify-center">
                            <a href="#" class="bg-white/80 backdrop-blur-sm px-8 py-3 rounded-lg font-medium text-amber-900 hover:bg-white/90 transition shadow-md">
                                Staff List
                            </a>
                        </div>

                        <!-- Station Cards Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @php
                                $stations = [
                                    ['name' => 'Shwetha', 'albums' => 4],
                                    ['name' => 'Hishma', 'albums' => 2],
                                    ['name' => 'Dahemi', 'albums' => 4],
                                    ['name' => 'Aamina', 'albums' => 4]
                                ];
                            @endphp

                            @foreach($stations as $station)
                            <div class="station-card bg-white/80 backdrop-blur-sm rounded-2xl p-6 cursor-pointer transition-all duration-300 hover:shadow-lg">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="w-16 h-16 bg-gradient-to-br from-sky-400 to-blue-600 rounded-full flex items-center justify-center">
                                        <i class="fas fa-train text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-800">{{ $station['name'] }}</h3>
                                        <p class="text-gray-600">{{ $station['albums'] }} Albums</p>
                                    </div>
                                </div>
                                <a href="#" class="text-amber-800 font-medium hover:underline">
                                    <i class="fas fa-chevron-right mr-2"></i>See Details
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Right Column - Lost and Found Reports -->
                    <div class="lg:col-span-1">
                        <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 h-full">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-xl font-semibold text-amber-900">Lost and Found Reports</h3>
                                <button class="text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                            </div>
                            
                            <!-- Reports List -->
                            <div class="space-y-4 max-h-96 overflow-y-auto">
                                @php
                                    $reports = [
                                        ['item' => 'Luggage lost', 'user' => 'aamina Fazeel'],
                                        ['item' => 'Brown Duffel', 'user' => 'Avery Davis'],
                                        ['item' => 'Blue Suitcase', 'user' => 'Cahaya Dewi'],
                                        ['item' => 'Beige Clutch', 'user' => 'Olivia Wilson'],
                                        ['item' => 'White Tote', 'user' => 'Yael Amari'],
                                        ['item' => 'Silver briefcase', 'user' => 'Juliana Silva'],
                                        ['item' => 'Black Backpack', 'user' => 'Itsuki Takahashi']
                                    ];
                                @endphp

                                @foreach($reports as $report)
                                <div class="report-item bg-white/90 backdrop-blur-sm rounded-lg p-4 cursor-pointer transition-all duration-300">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center">
                                            <i class="fas fa-suitcase text-white text-sm"></i>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-medium text-gray-800">{{ $report['item'] }}</h4>
                                            <p class="text-sm text-gray-600">{{ $report['user'] }}</p>
                                        </div>
                                        <i class="fas fa-chevron-right text-gray-400"></i>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Discover All Button -->
                            <div class="mt-6 text-center">
                                <a href="#" class="text-amber-800 font-medium hover:underline">
                                    Discover All
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
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
    </script>
</body>
</html>