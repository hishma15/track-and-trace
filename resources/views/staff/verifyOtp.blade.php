<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Track & Trace - Staff OTP Verification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="min-h-screen" style="background-image: url('/images/backgroundimg.jpeg'); background-size: cover; background-position: center;">

<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="max-w-6xl w-full flex flex-col lg:flex-row gap-12">
        
        <!-- Left Side - Branding -->
        <div class="flex-1 flex flex-col justify-center items-center text-center px-4 sm:px-8 lg:p-12">
            <h1 class="text-5xl sm:text-6xl lg:text-8xl font-black mb-4" style="color: #55372c; font-family: 'Anton', sans-serif;">
                TRACK N'<br>TRACE
            </h1>
            <div class="mt-8 space-y-2">
                <p class="text-2xl sm:text-3xl md:text-4xl font-light" style="color: #55372c; font-family: 'Poppins', sans-serif;">
                    QR BASED <br> LOST <br> LUGGAGE <br> MANAGEMENT <br> SYSTEM
                </p>
            </div>
        </div>

        <!-- Right Side - Staff OTP Form -->
        <div class="flex-1 flex flex-col justify-center p-12 rounded-3xl shadow-2xl bg-[#edede1]">
            <div class="max-w-md mx-auto w-full text-center">
                <h2 class="text-3xl sm:text-4xl font-semibold mb-6" style="color: #55372c; font-family: 'Poppins', sans-serif;">
                    Staff OTP Verification
                </h2>
                
                @if(session('status'))
                    <div class="bg-green-100 text-green-700 border border-green-300 p-3 rounded mb-6">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('staff.otp.verify') }}" class="space-y-6">
                    @csrf
                    <input type="text" name="otp" placeholder="Enter OTP" 
                           class="w-full px-0 py-3 text-lg border-0 border-b-2 border-gray-400 bg-transparent focus:border-gray-600 focus:outline-none focus:ring-0 transition-colors"
                           style="border-bottom-color: #8B4513;" required>
                    
                    <button type="submit" class="w-full py-4 px-6 text-xl font-semibold rounded-full transition-all duration-200 hover:opacity-90 focus:outline-none focus:ring-4 focus:ring-gray-300"
                            style="background-color: #55372c; color: #edede1;">
                        Verify OTP
                    </button>
                    
                    @error('otp') <p class="text-red-500 mt-2">{{ $message }}</p> @enderror
                </form>

                <form action="{{ route('staff.otp.resend') }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="w-full py-3 px-6 text-lg font-semibold rounded-full transition-all duration-200 hover:opacity-90 focus:outline-none focus:ring-4 focus:ring-gray-300"
                            style="background-color: #55372c; color: #edede1;">
                        Resend OTP
                    </button>
                </form>

                <div class="pt-6 text-center">
                    <a href="{{ route('staff.login') }}" class="text-xl font-semibold hover:underline" style="color: #55372c;">
                        Back to Login
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>
