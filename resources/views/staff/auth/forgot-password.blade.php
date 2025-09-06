<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Track & Trace - Forgot Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body class="min-h-screen" style="background-image: url('/images/backgroundimg.jpeg'); background-size: cover; background-position: center;">
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="max-w-6xl w-full flex flex-col lg:flex-row gap-12">
            
            <!-- Branding -->
            <div class="flex-1 flex flex-col justify-center items-center text-center">
                <h1 class="text-6xl lg:text-8xl font-black mb-4" style="color: #55372c; font-family: 'Anton', sans-serif;">
                    TRACK N'<br>TRACE
                </h1>
                <p class="text-2xl font-light" style="color: #55372c; font-family: 'Poppins', sans-serif;">
                    Reset Your Password
                </p>
            </div>

            <!-- Forgot Password Form -->
            <div class="flex-1 flex flex-col justify-center p-12 rounded-3xl shadow-2xl" style="background-color: #edede1;">
                <div class="max-w-md mx-auto w-full">
                    <div class="text-center mb-8">
                        <h2 class="text-4xl font-bold" style="color: #55372c;">Forgot Password</h2>
                        <p class="text-gray-600 mt-2">Enter your email to receive a reset link</p>
                    </div>

                    <!-- Success -->
                    @if (session('status'))
                        <div class="bg-green-100 text-green-700 border border-green-300 p-3 rounded mb-6 text-center">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Errors -->
                    @if ($errors->any())
                        <div class="bg-red-100 text-red-700 border border-red-300 p-3 rounded mb-6 text-center">
                            <ul class="list-disc pl-5 text-left">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('staff.password.email') }}" class="space-y-6">
                        @csrf
                        <div>
                            <label class="block text-xl font-semibold mb-2" style="color: #55372c;">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="w-full px-0 py-3 text-lg border-0 border-b-2 border-gray-400 bg-transparent 
                                          focus:border-gray-600 focus:outline-none" required>
                        </div>

                        <button type="submit"
                                class="w-full py-4 px-6 text-xl font-semibold rounded-full transition-all duration-200 
                                       hover:opacity-90 focus:ring-4 focus:ring-gray-300"
                                style="background-color: #55372c; color: #edede1;">
                            Send Reset Link
                        </button>

                        <div class="text-center pt-4">
                            <a href="{{ route('staff.staffLogin') }}" class="text-xl font-semibold hover:underline" style="color: #55372c;">
                                Back to Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
