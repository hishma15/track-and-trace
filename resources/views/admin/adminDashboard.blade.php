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
    <!-- Wrap everything in Alpine.js context -->
    <div x-data="registerStaffModal()" class="flex min-h-screen">
        
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
                    <div class="lg:col-span-4 space-y-6">
                        <!-- Welcome Card -->
                        <div class="rounded-2xl p-8 bg-[#55372c] bg-gradient-to-r from-[#7a4f3f] to-[#55372c] text-[#edede1]">
                            <div class="max-w-md">
                                <h2 class="text-3xl font-bold mb-2">Welcome to Track N' Trace.</h2>
                                <p class="text-lg mb-6 opacity-90">QR Based Lost Luggage management system</p>
                                
                                <div class="flex gap-4">
                                    <a href="#" class="bg-white/20 backdrop-blur-sm px-6 py-3 rounded-lg font-medium hover:bg-white/30 transition">
                                        Reports
                                    </a>
                                    <!-- Updated button with Alpine.js click handler -->
                                    <button
                                        @click="openModal = true"
                                        class="bg-white/20 backdrop-blur-sm px-6 py-3 rounded-lg font-medium hover:bg-white/30 transition"
                                        type="button"
                                    >
                                        Manage Staff
                                    </button>
                                </div>
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
                            @foreach($staff as $member)
                            <div class="station-card bg-white/80 backdrop-blur-sm rounded-2xl p-6 cursor-pointer transition-all duration-300 hover:shadow-lg">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="w-16 h-16 bg-gradient-to-br from-sky-400 to-blue-600 rounded-full flex items-center justify-center">
                                        <i class="fas fa-train text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <p>{{ $member->user ? $member->user->first_name : 'User not loaded' }}</p>
                                        <p class="text-gray-600">{{ $member->organization }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('admin.staff.profile.show', $member->id) }}" class="text-amber-800 font-medium hover:underline flex items-center">
                                    <i class="fas fa-chevron-right mr-2"></i>See Details
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
   
                        
                  
               
                </div>
            </div>
        </main>

        <!-- Include the modal (it will use the same Alpine.js context) -->
        @include('partials.register-staff-modal')
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

        // Register Staff Modal Function
        function registerStaffModal() {
            return {
                openModal: {{ $errors->any() ? 'true' : 'false' }}, // Keep modal open if errors exist
            }
        }
    </script>
</body>
</html>