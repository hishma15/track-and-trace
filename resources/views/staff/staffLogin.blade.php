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

    

</head>

<body class="min-h-screen" style="background-image: url('/images/backgroundimg.jpeg'); background-size: cover; background-position: center;">
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-6xl flex flex-col lg:flex-row gap-12">
            
            <!-- Left Side - Branding -->
            <div class="flex-1 flex flex-col justify-center items-center text-center px-4 sm:px-8 lg:p-12">
                <h1 class="text-5xl sm:text-6xl lg:text-8xl font-black mb-4" style="color: #55372c; font-family: 'Anton', sans-serif;">
                    TRACK N'<br>TRACE
                </h1>
                <div class="mt-8 space-y-2">
                    <p class="text-2xl sm:text-3xl md:text-4xl font-light" style="color: #55372c; font-family: 'Poppins', sans-serif;">
                        QR BASED 
                        <br> LOST
                        <br>LUGGAGE
                        <br> MANAGEMENT 
                        <br> SYSTEM
                    </p>
                </div>
            </div>
            
            <!-- Right Side - Form -->
            <div class="flex-1 bg-[#edede1] rounded-3xl shadow-2xl px-6 py-10 sm:p-12">
                <div class="max-w-md mx-auto">
                    <div class="text-center mb-8">
                        <p class="text-2xl sm:text-3xl font-medium" style="color: #55372c; font-family: 'Poppins', sans-serif;">STAFF</p>
                        <h2 class="text-3xl sm:text-4xl font-bold mb-2" style="color: #55372c;">
                            Welcome again!
                        </h2>
                        <p class="text-gray-600 text-base sm:text-lg">Please enter your details</p>
                    </div>

                    <form method="POST" action="{{ route('staff.login') }}" class="space-y-6">
                        @csrf

                        @if ($errors->has('login'))
                            <div class="bg-red-100 text-red-700 border border-red-300 p-3 rounded text-center">
                                {{ $errors->first('login') }}
                            </div>
                        @endif

                        <!-- Username -->
                        <div>
                            <label for="login" class="block text-lg sm:text-xl font-semibold mb-2" style="color: #55372c;">Username or Email</label>
                            <input 
                                type="text" 
                                id="login" 
                                name="login" 
                                value="{{ old('login') }}"
                                class="w-full px-0 py-3 text-lg border-0 border-b-2 border-gray-400 bg-transparent focus:border-gray-600 focus:outline-none"
                                style="border-bottom-color: #8B4513;"
                                required
                            >
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-lg sm:text-xl font-semibold mb-2" style="color: #55372c;">Password</label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password" 
                                    class="w-full px-0 py-3 pr-12 text-lg border-0 border-b-2 border-gray-400 bg-transparent focus:border-gray-600 focus:outline-none"
                                    style="border-bottom-color: #8B4513;"
                                    required
                                >
                                <button 
                                    type="button" 
                                    id="togglePassword"
                                    class="absolute right-0 top-3 p-1 text-gray-600 hover:text-gray-800"
                                >
                                    <i id="eyeIcon" class="fa-solid fa-eye text-xl"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="pt-4">
                            <button 
                                type="submit" 
                                class="w-full py-4 px-6 text-lg sm:text-xl font-semibold rounded-full transition hover:opacity-90"
                                style="background-color: #55372c; color: #edede1;"
                            >
                                Log In
                            </button>
                        </div>

                        <!-- Create Account -->
                        <div class="text-center pt-4">
                            <a href="{{ route('staff.register') }}" class="text-lg sm:text-xl font-semibold hover:underline" style="color: #55372c;">
                                Create Account
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Password Toggle -->
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            const isPassword = passwordField.type === 'password';
            passwordField.type = isPassword ? 'text' : 'password';
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });
    </script>
</body>

</html>