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

</head>
<!-- <body class="relative h-screen flex items-center pt-20" style="background-image: url('/images/backgroundimg.jpeg'); background-size: cover; background-position: center;">
    <!-- Text section -->
    <!-- <section> -->
        <!-- <h1 class="font-anton text-7xl font-bold leading-tight uppercase text- drop-shadow-lg">TRACK N'<br>TRACE -->
        <!-- </h1> -->

    <!-- </section> -->
    <!-- Form section 
</body> -->

<!-- <body class="min-h-screen" style="background-color: #E5D5C7;"> -->
<body class="min-h-screen" style="background-image: url('/images/backgroundimg.jpeg'); background-size: cover; background-position: center;">    
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="max-w-6xl w-full flex overflow-hidden">
            
            <!-- Left Side - Branding -->
            <div class="flex-1 flex flex-col justify-center items-center p-12 text-center">
                <div class="mb-8">
                    <h1 class="font-black text-8xl mb-4" style="color: #55372c; font-family: 'Anton', sans-serif;">
                        TRACK N'<br>TRACE
                    </h1>
                </div>
                
                <div class="mt-12">
                    <p class="text-4xl mb-2 font-light" style="color: #55372c; font-family: 'Poppins', sans-serif;">
                        QR BASED
                    </p>
                    <p class="text-4xl font-light mb-2" style="color: #55372c; font-family: 'Poppins', sans-serif;">
                        LOST
                    </p>
                    <p class="text-4xl font-light mb-2" style="color: #55372c; font-family: 'Poppins', sans-serif;">
                        LUGGAGE
                    </p>
                    <p class="text-4xl font-light mb-2" style="color: #55372c; font-family: 'Poppins', sans-serif;">
                        MANAGMENT
                    </p>
                    <p class="text-4xl font-light" style="color: #55372c; font-family: 'Poppins', sans-serif;">
                        SYSTEM
                    </p>
                </div>
            </div>
            
            <!-- Right Side - Traveler Login Form -->
            <div class="flex-1 flex flex-col justify-center p-12 rounded-3xl shadow-2xl"  style="background-color: #edede1;">
                <div class="max-w-md mx-auto w-full">
                    <div class="text-center mb-8">
                        <h2 class="text-4xl font-bold mb-2" style="color: #55372c;">
                            Welcome again!
                        </h2>
                        <p class="text-gray-600 text-lg">
                            Please enter your details
                        </p>
                    </div>
                    
                    <form method="POST" action="{{ route('traveler.login') }}" class="space-y-6">
                        @csrf
                        
                        <!-- Username or Email Field -->
                        <div>
                            <label for="login" class="block text-xl font-semibold mb-2" style="color: #55372c;">
                                Username or Email
                            </label>
                            <input 
                                type="text" 
                                id="login" 
                                name="login" 
                                value="{{ old('login') }}"
                                class="w-full px-0 py-3 text-lg border-0 border-b-2 border-gray-400 bg-transparent focus:border-gray-600 focus:outline-none focus:ring-0 transition-colors"
                                style="border-bottom-color: #8B4513;"
                                required
                            >
                            @error('username')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <!-- Password Field -->
                        <div>
                            <label for="password" class="block text-xl font-semibold mb-2" style="color: #55372c;">
                                Password
                            </label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password" 
                                    class="w-full px-0 py-3 pr-12 text-lg border-0 border-b-2 border-gray-400 bg-transparent focus:border-gray-600 focus:outline-none focus:ring-0 transition-colors"
                                    style="border-bottom-color: #8B4513;"
                                    required
                                >
                                <button 
                                    type="button" 
                                    id="togglePassword"
                                    class="absolute right-0 top-3 p-1 text-gray-600 hover:text-gray-800 focus:outline-none"
                                >
                                    <svg id="eyeIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <!-- Forgot Password Link -->
                        <div class="flex justify-end">
                            {{--
                                <a href="{{ route('password.request') }}" class="text-gray-600 hover:text-gray-800 text-lg">
                                Forgot Password?
                            </a>
                            --}}
                        </div>
                        
                        <!-- Login Button -->
                        <div class="pt-4">
                            <button 
                                type="submit" 
                                class="w-full py-4 px-6 text-xl font-semibold rounded-full transition-all duration-200 hover:opacity-90 focus:outline-none focus:ring-4 focus:ring-gray-300"
                                style="background-color: #55372c; color: #edede1;"
                            >
                                Log In
                            </button>
                        </div>
                        
                        <!-- Create Account Link -->
                        <div class="text-center pt-4">
                            <a href="{{ route('traveler.register') }}" class="text-xl font-semibold hover:underline" style="color: #55372c;">
                                Create Account
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 