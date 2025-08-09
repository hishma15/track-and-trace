<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track N' Trace</title>
    @vite('resources/css/app.css') <!-- Tailwind CSS -->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Lustria&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    
        <!--Icons from fontawsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body class="min-h-screen flex items-center justify-center" style="background-image: url('/images/backgroundimg.jpeg'); background-size: cover; background-position: center;">
    

    <div class="max-w-6xl mx-auto text-center">
    <!-- Main Title -->
    <div class="mb-12 flex flex-col md:flex-row justify-center items-center gap-5">
        <h1 class="font-black text-8xl mb-4 md:text-right mt-5 p-5" style="color: #55372c; font-family: 'Anton', sans-serif;">
            TRACK N'<br>TRACE
        </h1>
        <p class="text-4xl text-brown font-medium mt-4" style="color: #55372c; font-family: 'Poppins', sans-serif; letter-spacing: 1px;">
            QR BASED LOST<br>
            LUGGAGE<br>
            MANAGEMENT<br>
            SYSTEM
        </p>
    </div>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 border border-green-300 p-3 rounded mb-4 text-center mx-auto w-fit mt-4">
            {{ session('success') }}
        </div>
    @endif

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
    
    <section class="text-center mt-8 mb-5 md:mb-0">
        <h2 class="text-4xl font-bold text-[#55372c]">Want to learn more?</h2>
        <a href="{{ route('about') }}" class="mt-4 inline-block bg-[#55372c] text-[#fcf7ed] text-2xl px-6 py-2 rounded-full transition-all duration-200 hover:opacity-90 focus:outline-none focus:ring-4 focus:ring-gray-300">Read About Us</a>
    </section>

</div>

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
    </script>


</body>
</html>