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
                        <div>
                            <p class="text-[#55372c] text-3xl font-medium" style="color: #55372c; font-family: 'Poppins', sans-serif;">ADMIN</p>
                        </div>  
                        <h2 class="text-4xl font-bold mb-2" style="color: #55372c;">
                            Welcome again!
                        </h2>
                        <p class="text-gray-600 text-lg">
                            Please enter your details
                        </p>
                    </div>
                    
                    <form method="POST" action="{{ route('admin.login') }}" class="space-y-6">
                        @csrf

                        @if ($errors->any())
                            <div class="bg-red-100 text-red-700 border border-red-300 p-3 rounded mb-6 text-center">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-xl font-semibold mb-2" style="color: #55372c;">
                                Email
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                class="w-full px-0 py-3 text-lg border-0 border-b-2 border-gray-400 bg-transparent focus:border-gray-600 focus:outline-none focus:ring-0 transition-colors"
                                style="border-bottom-color: #8B4513;"
                                required
                            >
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
                                    <i id="eyeIcon" class="fa-solid fa-eye text-xl"></i>
                                </button>
                            </div>
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
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
    
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