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

        <!--Icons from fontawsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Alpine JS  -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>

        .welcome-card {
            background: linear-gradient(135deg, #8B4513 0%, #654321 100%);
        }
        
        /* .action-card {
            background: linear-gradient(135deg, #f0f8ff 0%, #e6f3ff 100%);
            border: 1px solid #e0e6ed;
            transition: all 0.3s ease;
        } */
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
        
    </style>
    

</head>

<body class="min-h-screen"  style="background-image: url('/images/backgroundimg.jpeg'); background-size: cover; background-position: center;">
    <div class="flex min-h-screen">
        
        <!-- Sidebar -->
        @include('partials.traveler-sidebar', ['active' => 'dashboard'])

        <!-- Main Content -->
        <main class="flex-1 overflow-hidden">
            <!-- Header -->
            <header class="bg-white/80 backdrop-blur-sm border-b border-gray-200 px-8 py-4">
                <div class="flex items-center justify-between">

                    <h1 class="text-2xl font-semibold text-[#55372c]">Staff Dashboard</h1>

                    
                    <div class="flex items-center gap-4">
                        <!-- Search Box -->
                        <!-- <div class="relative">
                            <input type="text" 
                                   placeholder="Search..." 
                                   class="search-box pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent w-80">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div> -->
                        
                        <!-- User Profile
                        <div class="flex items-center gap-3">
                            <span class="text-gray-700 font-medium">Traveler</span>
                            <div class="profile-avatar w-10 h-10 rounded-full flex items-center justify-center">
                                <div class="w-8 h-8 bg-green-500 rounded-full"></div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="p-8 overflow-y-auto">

            @if (session('success'))
                <div class="bg-green-100 text-green-700 border border-green-300 p-3 rounded mb-4 text-center">
                    {{ session('success') }}
                </div>
            @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 h-full">
                    <!-- Left Column - Welcome & Actions -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Welcome Card -->
                        <div class="rounded-2xl p-8 bg-[#55372c] bg-gradient-to-r from-[#7a4f3f] to-[#55372c] text-[#edede1]">
                            <div class="max-w-md">
                                <h2 class="text-3xl font-bold mb-2">Welcome to Track N' Trace.</h2>
                                <p class="text-lg mb-6 opacity-90">QR Based Lost Luggage management system</p>
                                
                                <div class="flex gap-4">
                                    <button class="bg-white/20 backdrop-blur-sm px-6 py-3 rounded-lg font-medium hover:bg-white/30 transition">
                                        Reports
                                    </button>
                                    <!-- <button class="bg-white/20 backdrop-blur-sm px-6 py-3 rounded-lg font-medium hover:bg-white/30 transition">
                                        Give Feedback
                                    </button> -->
                                    
                                    <!-- Feedback Popup -->
<div x-data="feedbackModal()" x-init="rating = 0">

    <!-- Trigger Button -->
    <div class="bg-white/20 backdrop-blur-sm px-6 py-3 rounded-lg font-medium hover:bg-white/30 transition" @click="openModal = true">
        <p>Give Feedback</p>
    </div>

    <!-- Modal -->
    <div
        x-show="openModal"
        x-transition
        class="fixed inset-0 flex items-center justify-center z-50"
        style="background-color: rgba(0, 0, 0, 0.7);"
    >
        <!-- Modal Content -->
        <div class="relative p-6 rounded-xl shadow-xl w-full max-w-2xl mx-auto max-h-[90vh] overflow-y-auto"
    style="background-image: url('/images/backgroundimg.jpeg'); background-size: cover; background-position: center;">
            <button @click="openModal = false" class="absolute top-2 right-4 text-gray-500 text-2xl hover:text-gray-700 cursor-pointer">&times;</button>

            <h1 class="text-2xl font-normal mb-6" style="color: #55372c;">Submit Feedback</h1>

            <!-- Top Banner -->
            <div class="rounded-t-xl p-6 flex justify-between items-center mb-4" style="background-color: #55372c; color: #edede1;">
                <div>
                    <h2 class="text-xl font-bold">We value your feedback!</h2>
                    <p class="text-sm">Rate your experience and leave comments to help us improve.</p>
                </div>
            </div>

            <form action="{{ route('feedback.store') }}" method="POST" class="rounded-b-xl p-6 shadow space-y-4 bg-[#edede1]/45">
                @csrf

                <!-- Feedback Rating Section -->
<div x-data="ratingComponent()" class="space-y-4 max-w-md mx-auto p-6 rounded-lg ">
    <label class="block font-medium text-lg text-[#55372c]">Rate Your Experience <span class="text-red-500">*</span></label>
    
    <div class="flex items-center gap-3">
        <!-- Stars -->
        <template x-for="starIndex in 5" :key="starIndex">
            <button 
                type="button" 
                class="text-4xl cursor-pointer transition hover:text-yellow-400 focus:outline-none"
                :class="{
    'text-yellow-400 fa-solid': starIndex <= (hoverRating || currentRating),
    'text-[#55372c] fa-regular': starIndex > (hoverRating || currentRating)
  }"
                @click="setRating(starIndex)"
                @mouseover="hoverRating = starIndex"
                @mouseleave="hoverRating = 0"
                :aria-label="`Rate ${starIndex} stars`"
            >
                <i class="fa-solid fa-star" x-show="(hoverRating || currentRating) >= starIndex"></i>
                <i class="fa-regular fa-star" x-show="(hoverRating || currentRating) < starIndex"></i>
            </button>
        </template>

        <!-- Rating Text -->
        <div class="text-xl font-semibold text-[#55372c] min-w-[150px]" x-text="ratingMessage"></div>
    </div>

    <!-- Hidden input to send rating to backend -->
    <input type="hidden" name="rating" :value="currentRating" required>
    @if ($errors->has('rating'))
    <div class="text-red-600 font-semibold mb-2">
        {{ $errors->first('rating') }}
    </div>
@endif

</div>

                <!-- Subject -->
<div class="text-black">
    <label class="block font-medium mb-2">Subject <span class="text-red-500">*</span></label>
    <input type="text" name="subject" required class="w-full border rounded px-3 py-2" placeholder="Enter subject (e.g., Luggage Issue, Staff Behavior, QR Code Error)">
</div>

                <!-- Feedback message -->
                <div class="text-black"> 
                    <label class="block font-medium">Message <span class="text-red-500">*</span></label>
                    <textarea name="message" required class="w-full border rounded px-3 py-2"></textarea>
                </div>

                <button type="submit" class="w-full py-4 px-6 text-xl font-semibold rounded-full transition-all duration-200 hover:opacity-90 focus:outline-none focus:ring-4 focus:ring-gray-300" style="background-color: #55372c; color: #edede1;">
                    Submit Feedback
                </button>
            </form>
        </div>
    </div>
</div>


                                </div>
                            </div>

                        </div>

                        <!-- Quick Report Button -->
                        <div class="flex justify-center">
                            <button class="bg-white/80 backdrop-blur-sm px-8 py-3 rounded-lg cursor-pointer font-medium text-[#55372c] hover:bg-white/60 transition shadow-md">
                                REPORT
                            </button>
                        </div>

                        <!-- Action Cards -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Register Luggages -->
                            <!-- <div class="action-card rounded-2xl p-6 cursor-pointer bg-white/80 transition-all">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 bg-orange-100 rounded-xl flex items-center justify-center">
                                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                        </svg>
                                    </div>
                                     <div>
                                        <!-- <h3 class="text-xl font-semibold text-gray-800">Register Luggages</h3> -->
                                        <!-- <a href="{{ route('luggage.create') }}" class="text-xl font-semibold text-gray-800">Register Luggage</a>
                                    </div>
                                </div>
                            </div>   -->

                            @include('partials.register-luggage-popup')

                            <!-- Report Lost Luggage -->
                            <div class="action-card rounded-2xl p-6 cursor-pointer bg-white/80 transition-all">
                                <div class="flex items-center gap-4">
                                    <div class="w-20 h-20 bg-teal-100 rounded-xl flex items-center justify-center">
                                        <img src="{{ asset('images/report.png') }}" alt="Report" class="w-12 h-17">
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-800">Report Lost Luggage</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Profile Details -->
                    <div class="lg:col-span-1" >
                        <div class="bg-white/80 rounded-2xl p-10 h-full">
                            <h3 class="text-xl font-semibold text-[#55372c] mb-6 text-center">Profile Details</h3>
                            
                            <!-- Profile Avatar -->
                            <!-- <div class="flex justify-center mb-6">
                                <div class="profile-avatar w-24 h-24 rounded-full flex items-center justify-center">
                                    <div class="w-20 h-20 bg-green-500 rounded-full"></div>
                                </div>
                            </div> -->

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
                                <a href="{{ route('staff.profile.show') }}" class="flex items-center gap-2 bg-[#55372c] text-[#edede1] px-6 py-3 rounded-lg font-medium transition-all duration-200  hover:opacity-90 focus:outline-none focus:ring-4 focus:ring-gray-300">
                                    <span>EDIT DETAILS</span>
                                    <i class="fas fa-chevron-right text-sm"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            

        </main>
    </div>

    <!-- Footer -->
     @include('partials.footer')

    <script>
        setTimeout(() => {
            const alert = document.querySelector('.bg-green-100');
            if (alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';

                // Remove the element from DOM after fade-out
                setTimeout(() => {
                    alert.remove();
                }, 500); // wait for fade-out transition to finish
            }
        }, 2000);

        //Rating
        function ratingComponent() {
        return {
            currentRating: 0,
            hoverRating: 0,
            messages: {
                1: "Poor",
                2: "Fair",
                3: "Good",
                4: "Very Good",
                5: "Excellent"
            },
            setRating(rating) {
                this.currentRating = rating;
            },
            get ratingMessage() {
                return this.hoverRating 
                    ? this.messages[this.hoverRating] 
                    : this.currentRating 
                        ? this.messages[this.currentRating] 
                        : '';
            }
        }
    }

    //If error popup stays.
    function feedbackModal() {
        return {
        openModal: {{ $errors->any() ? 'true' : 'false' }},
        rating: 0,
        }
    }


    </script>
</body>

</html>