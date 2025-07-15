<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Track & Trace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">

    <!-- Header -->
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

    <!-- Hero Section -->
    <section class="relative h-screen flex items-center pt-20" style="background-size: cover; background-position: center;">
        
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/25"></div>

        <!-- Content -->
        <div class="relative z-10 w-full max-w-7xl mx-auto px-6 gap-6 items-center">
            
            <!-- Left Content -->
            <div class="text-white">
                <h2 class="text-4xl text-left md:text-5xl font-extrabold mb-4 leading-tight">
                    Lost Your Luggage?<br>
                    We’ll Help You Find It
                </h2>

            </div>

            <!-- Right Content -->
            <div class="text-gray-100 text-right text-2xl p-4 md:p-6">
                <h3>A Smart QR-based Luggage Recovery System for Sri Lanka Railways.</h3>
            </div>

            <a href="/register" class="mt-4 inline-block bg-gray-900 hover:bg-black text-white  text-2xl font-medium px-6 py-3 rounded-full">
                Register Now
            </a>

        </div>
    </section>

    <!-- New Section: About or Info -->
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
    </section>
    



</body>
</html>
