<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track N' Trace</title>
    @vite('resources/css/app.css') <!-- Tailwind CSS -->

    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Lustria&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    
</head>

<body class="min-h-screen flex items-center justify-center" style="background-image: url('/images/backgroundimg.jpeg'); background-size: cover; background-position: center;">

    <div class="max-w-6xl mx-auto text-center">
    <!-- Main Title -->
    <div class="mb-16 flex flex-row justify-center items-start gap-20">
        <h1 class="font-black text-8xl mb-4 text-right" style="color: #55372c; font-family: 'Anton', sans-serif;">
            TRACK N'<br>TRACE
        </h1>
        <p class="text-4xl text-brown font-medium mt-8" style="color: #55372c; font-family: 'Poppins', sans-serif; letter-spacing: 1px;">
            QR BASED LOST<br>
            LUGGAGE<br>
            MANAGEMENT<br>
            SYSTEM
        </p>
    </div>

    <!-- Portal Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-5xl mx-auto">
        <!-- Staff Portal -->
        <div class="bg-opacity-80 backdrop-blur-sm rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105" style="background-color: #fcf7ed">
            <a href="{{ route('staff.login') }}" class="block">
                <div class="flex items-center space-x-6">
                    <img src="{{ asset('images/staff.png') }}" alt="Staff" class="w-16 h-16 mb-2">
                    <div class="text-left" style="color: #55372c; font-family: 'Poppins', sans-serif;">
                        <h2 class="text-3xl font-bold">STAFF</h2>
                        <h3 class="text-3xl font-bold">PORTAL</h3>
                    </div>
                </div>
            </a>
        </div>

        <!-- Traveler Portal -->
        <div class="bg-opacity-80 backdrop-blur-sm rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105" style="background-color: #fcf7ed">
            <a href="{{ route('traveler.travelerLogin') }}" class="block">
                <div class="flex items-center space-x-6">
                    <img src="{{ asset('images/traveler.png') }}" alt="Staff" class="w-16 h-16 mb-2">
                    <div class="text-left" style="color: #55372c; font-family: 'Poppins', sans-serif;">
                        <h2 class="text-3xl font-bold">TRAVELER</h2>
                        <h3 class="text-3xl font-bold">PORTAL</h3>
                    </div>
                </div>
            </a>
        </div>

        <!-- Admin Portal -->
        <div class="bg-opacity-80 backdrop-blur-sm rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 md:col-span-2 lg:col-span-1" style="background-color: #fcf7ed">
            <a href="{{ route('admin.login') }}" class="block">
                <div class="flex items-center space-x-6">
                    <img src="{{ asset('images/admin.png') }}" alt="Staff" class="w-16 h-16 mb-2">
                    <div class="text-left" style="color: #55372c; font-family: 'Poppins', sans-serif;">
                        <h2 class="text-3xl font-bold">ADMIN</h2>
                        <h3 class="text-3xl font-bold">PORTAL</h3>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
    

</body>
</html>

    <!-- Header
    <header class="backdrop-blur bg-white/40 fixed top-0 w-full z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-black">Track </h1>
                <h3 class="text-xl font-bold text-black">Track Smarter, Travel Safer</h3>
            </div>

            <nav class="space-x-6 text-xl font-medium text-black">
                <a href="/" class="hover:underline">Home</a>
                <a href="#about" class="hover:underline">About</a>
                <a href="/login" class="hover:underline">Traveler</a>
                <a href="/staff/login" class="hover:underline">Staff</a>
            </nav>
        </div>

    </header>

    <!-- Hero Section 
    <section class="relative h-screen flex items-center pt-20" style="background-image: url('/images/bluetrain.png'); background-size: cover; background-position: center;">
        
        <!-- Overlay 
        <div class="absolute inset-0 bg-black/25"></div>

        <!-- Content 
        <div class="relative z-10 w-full max-w-7xl mx-auto px-6 gap-6 items-center">
            
            <!-- Left Content
            <div class="text-white">
                <h2 class="text-4xl text-left md:text-5xl font-extrabold mb-4 leading-tight">
                    Lost Your Luggage?<br>
                    We’ll Help You Find It
                </h2>

            </div>

            <!-- Right Content 
            <div class="text-gray-100 text-right text-2xl p-4 md:p-6">
                <h3>A Smart QR-based Luggage Recovery System for Sri Lanka Railways.</h3>
            </div>

            <a href="/register" class="mt-4 inline-block bg-gray-900 hover:bg-black text-white  text-2xl font-medium px-6 py-3 rounded-full">
                Register Now
            </a>

        </div>
    </section>

    <!-- New Section: About or Info
    <section id="about" class="bg-white py-20">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold text-black mb-6">HOW IT WORKS</h2>
            <div class="grid md:grid-cols-3 gap-8 text-gray-700 text-left">
                <div>
                    <h3 class="text-xl font-semibold mb-2">1. Register</h3>
                    <p>Create an account as a traveler or staff member to begin.</p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-2">2. Tag Your Luggage</h3>
                    <p>Enter luggage details and print your personalized QR code.</p>
                </div>
                <div>
                    <h3 class="text-xl font-semibold mb-2">3. Recover Quickly</h3>
                    <p>Get notified instantly when your luggage is found.</p>
                </div>
            </div>
        </div>
    </section> -->
    