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

<body class="min-h-screen" style="background-image: url('/images/backgroundimg.jpeg'); background-size: cover; background-position: center;"> 
        <!-- Wrapper Flex Container -->
    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="w-64 text-brown-800 p-6 flex flex-col justify-between" style="background-color: #dec9ae;">
            <div>
                <div class="text-2xl font-bold flex items-center gap-2 mb-10">
                    <img src="{{ asset('images/luggage-icon.png') }}" alt="Logo" class="w-10 h-10">
                    <span>Track N’ Trace</span>
                </div>
            </div>

            <div class="text-sm space-y-4">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-brown-700" fill="currentColor" viewBox="0 0 20 20"><path d="M11 17a1 1 0 01-.117-1.993L11 15h1a1 1 0 01.117 1.993L12 17h-1zm-3-4a1 1 0 01-.117-1.993L8 11h5a1 1 0 01.117 1.993L13 13H8zm3-4a1 1 0 01-.117-1.993L11 7h2a1 1 0 01.117 1.993L13 9h-2z"/></svg>
                    <span>Settings</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-brown-700" fill="currentColor" viewBox="0 0 20 20"><path d="M8.257 3.099c.366-.446.957-.535 1.414-.21l.09.082 5 5c.35.35.385.902.082 1.29l-.082.09-5 5c-.446.366-1.038.277-1.414-.21l-.082-.09-5-5c-.35-.35-.385-.902-.082-1.29l.082-.09 5-5z"/></svg>
                    <span>Help & Support</span>
                </div>
            </div>
        </aside>

        <!-- Registration Form -->
        <main class="flex-1 px-12 py-8">
            <h1 class="text-2xl font-normal mb-6" style="color: #55372c;">Staff Registration Form</h1>

            <div class="rounded-t-xl p-6 flex justify-between items-center mb-4" style="background-color: #55372c; color:  #edede1;">
                <div>
                    <h2 class="text-xl font-bold">Welcome to Track N’ Trace.</h2>
                    <p class="text-sm">QR Based Lost Luggage Management System</p>
                </div>
                <img src="{{ asset('images/register-banner.png') }}" alt="Banner" class="w-24 h-auto">
            </div>

            <form action="{{ route('traveler.register') }}" method="POST" class="rounded-b-xl p-6 shadow space-y-4 bg-[#edede1]/45">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Your form fields -->
                    <div>
                        <label class="block mb-1 font-medium" style="color: #55372c;">First Name</label>
                        <input type="text" name="first_name" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block mb-1 font-medium" style="color: #55372c;">Last Name</label>
                        <input type="text" name="last_name" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block mb-1 font-medium" style="color: #55372c;">Email Address</label>
                        <input type="email" name="email" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block mb-1 font-medium" style="color: #55372c;">Username</label>
                        <input type="text" name="username" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block mb-1 font-medium" style="color: #55372c;">Phone Number</label>
                        <input type="text" name="phone_no" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block mb-1 font-medium" style="color: #55372c;">National ID</label>
                        <input type="text" name="national_id" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block mb-1 font-medium" style="color: #55372c;">Password</label>
                        <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block mb-1 font-medium" style="color: #55372c;">Repeat Password</label>
                        <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2" required>
                    </div>
                </div>

                <!-- <button type="submit" class="w-full mt-6 py-3 font-bold rounded hover:bg-[#5c3726] transition"  style="background-color: #55372c; color:  #edede1;">
                    REGISTER NOW
                </button> -->
                <button 
                    type="submit" 
                    class="w-full py-4 px-6 text-xl font-semibold rounded-full transition-all duration-200 hover:opacity-90 focus:outline-none focus:ring-4 focus:ring-gray-300"
                    style="background-color: #55372c; color: #edede1;"
                >
                    REGISTER NOW
                </button>
            </form>
        </main>
    </div> <!-- end flex wrapper -->

</body>
</html>


 <!-- <div class="min-h-screen flex">
        <!-- Sidebar 
        <div class="w-1/4 bg-sand-light p-8 flex flex-col">
            <!-- Logo 
            <div class="flex items-center mb-12">
                <div class="w-12 h-12 bg-brown rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L2 7L12 12L22 7L12 2Z"/>
                        <path d="M2 17L12 22L22 17"/>
                        <path d="M2 12L12 17L22 12"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-brown-dark">Track N'</h1>
                    <h2 class="text-2xl font-bold text-brown-dark">Trace</h2>
                </div>
            </div>

            <!-- Navigation 
            <nav class="space-y-4 mt-auto">
                <div class="flex items-center space-x-3 text-brown-dark">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    <span>Settings</span>
                </div>
                <div class="flex items-center space-x-3 text-brown-dark">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z"/>
                    </svg>
                    <span>Help & Support</span>
                </div>
            </nav>
        </div>

        <!-- Main Content 
        <div class="flex-1 bg-white">
            <div class="p-8">
                <h1 class="text-3xl font-bold text-brown-dark mb-8">Traveler Registration Form</h1>
                
                <!-- Welcome Banner 
                <div class="bg-brown text-white rounded-2xl p-8 mb-8 relative overflow-hidden">
                    <div class="relative z-10">
                        <h2 class="text-3xl font-bold mb-2">Welcome to Track N' Trace.</h2>
                        <p class="text-lg opacity-90">QR Based Lost Luggage management system</p>
                    </div>
                    
                    <!-- Decorative Elements 
                    <div class="absolute top-4 right-4 w-8 h-8 bg-orange-400 rounded-full opacity-60"></div>
                    <div class="absolute top-12 right-12 w-4 h-4 bg-yellow-400 rounded-full opacity-60"></div>
                    <div class="absolute bottom-4 right-4 w-6 h-6 bg-red-400 rounded-full opacity-60"></div>
                    <div class="absolute bottom-12 right-12 w-3 h-3 bg-blue-400 rounded-full opacity-60"></div>
                    
                    <!-- Illustration 
                    <div class="absolute right-8 top-4 bottom-4 w-64 flex items-center justify-center">
                        <div class="relative">
                            <!-- Phone mockup 
                            <div class="w-32 h-48 bg-white rounded-2xl shadow-lg flex items-center justify-center">
                                <div class="w-24 h-40 bg-gray-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-12 h-12 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM10.5 7H13.5C14.6 7 15.5 7.9 15.5 9V11.5H13.5V22H10.5V11.5H8.5V9C8.5 7.9 9.4 7 10.5 7Z"/>
                                    </svg>
                                </div>
                            </div>
                            <!-- Person figure 
                            <div class="absolute -left-16 top-8 w-16 h-32 bg-orange-400 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM10.5 7H13.5C14.6 7 15.5 7.9 15.5 9V11.5H13.5V22H10.5V11.5H8.5V9C8.5 7.9 9.4 7 10.5 7Z"/>
                                </svg>
                            </div>
                            <!-- Gear icons 
                            <div class="absolute -top-2 -left-2 w-6 h-6 bg-gray-400 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 15.5A3.5 3.5 0 0 1 8.5 12A3.5 3.5 0 0 1 12 8.5A3.5 3.5 0 0 1 15.5 12A3.5 3.5 0 0 1 12 15.5M19.43 12.98C19.47 12.66 19.5 12.34 19.5 12C19.5 11.66 19.47 11.34 19.43 11.02L21.54 9.37C21.73 9.22 21.78 8.95 21.66 8.73L19.66 5.27C19.54 5.05 19.27 4.96 19.05 5.05L16.56 6.05C16.04 5.65 15.48 5.32 14.87 5.07L14.49 2.42C14.46 2.18 14.25 2 14 2H10C9.75 2 9.54 2.18 9.51 2.42L9.13 5.07C8.52 5.32 7.96 5.66 7.44 6.05L4.95 5.05C4.73 4.96 4.46 5.05 4.34 5.27L2.34 8.73C2.22 8.95 2.27 9.22 2.46 9.37L4.57 11.02C4.53 11.34 4.5 11.67 4.5 12C4.5 12.33 4.53 12.66 4.57 12.98L2.46 14.63C2.27 14.78 2.22 15.05 2.34 15.27L4.34 18.73C4.46 18.95 4.73 19.03 4.95 18.95L7.44 17.94C7.96 18.34 8.52 18.68 9.13 18.93L9.51 21.58C9.54 21.82 9.75 22 10 22H14C14.25 22 14.46 21.82 14.49 21.58L14.87 18.93C15.48 18.68 16.04 18.34 16.56 17.94L19.05 18.95C19.27 19.03 19.54 18.95 19.66 18.73L21.66 15.27C21.78 15.05 21.73 14.78 21.54 14.63L19.43 12.98Z"/>
                                </svg>
                            </div>
                            <div class="absolute -bottom-2 -right-2 w-6 h-6 bg-gray-400 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 15.5A3.5 3.5 0 0 1 8.5 12A3.5 3.5 0 0 1 12 8.5A3.5 3.5 0 0 1 15.5 12A3.5 3.5 0 0 1 12 15.5M19.43 12.98C19.47 12.66 19.5 12.34 19.5 12C19.5 11.66 19.47 11.34 19.43 11.02L21.54 9.37C21.73 9.22 21.78 8.95 21.66 8.73L19.66 5.27C19.54 5.05 19.27 4.96 19.05 5.05L16.56 6.05C16.04 5.65 15.48 5.32 14.87 5.07L14.49 2.42C14.46 2.18 14.25 2 14 2H10C9.75 2 9.54 2.18 9.51 2.42L9.13 5.07C8.52 5.32 7.96 5.66 7.44 6.05L4.95 5.05C4.73 4.96 4.46 5.05 4.34 5.27L2.34 8.73C2.22 8.95 2.27 9.22 2.46 9.37L4.57 11.02C4.53 11.34 4.5 11.67 4.5 12C4.5 12.33 4.53 12.66 4.57 12.98L2.46 14.63C2.27 14.78 2.22 15.05 2.34 15.27L4.34 18.73C4.46 18.95 4.73 19.03 4.95 18.95L7.44 17.94C7.96 18.34 8.52 18.68 9.13 18.93L9.51 21.58C9.54 21.82 9.75 22 10 22H14C14.25 22 14.46 21.82 14.49 21.58L14.87 18.93C15.48 18.68 16.04 18.34 16.56 17.94L19.05 18.95C19.27 19.03 19.54 18.95 19.66 18.73L21.66 15.27C21.78 15.05 21.73 14.78 21.54 14.63L19.43 12.98Z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Registration Form 
                <div class="bg-sand-light rounded-2xl p-8">
                    <form method="POST" action="{{ route('traveler.register') }}" class="space-y-6">
                        @csrf
                        
                        <!-- First Name and Last Name 
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="first_name" class="block text-brown-dark font-semibold mb-2">First Name</label>
                                <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required 
                                    class="w-full px-4 py-3 bg-white border border-brown-dark/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-brown-dark focus:border-brown-dark">
                                @error('first_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="last_name" class="block text-brown-dark font-semibold mb-2">Last Name</label>
                                <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required 
                                    class="w-full px-4 py-3 bg-white border border-brown-dark/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-brown-dark focus:border-brown-dark">
                                @error('last_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Email Address 
                        <div>
                            <label for="email" class="block text-brown-dark font-semibold mb-2">Email Address</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                                class="w-full px-4 py-3 bg-white border border-brown-dark/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-brown-dark focus:border-brown-dark">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone Number and National ID 
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="phone" class="block text-brown-dark font-semibold mb-2">Phone Number</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required 
                                    class="w-full px-4 py-3 bg-white border border-brown-dark/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-brown-dark focus:border-brown-dark">
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="national_id" class="block text-brown-dark font-semibold mb-2">National ID</label>
                                <input type="text" id="national_id" name="national_id" value="{{ old('national_id') }}" required 
                                    class="w-full px-4 py-3 bg-white border border-brown-dark/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-brown-dark focus:border-brown-dark">
                                @error('national_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Password and Repeat Password 
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="password" class="block text-brown-dark font-semibold mb-2">Password</label>
                                <input type="password" id="password" name="password" required 
                                    class="w-full px-4 py-3 bg-white border border-brown-dark/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-brown-dark focus:border-brown-dark">
                                @error('password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="password_confirmation" class="block text-brown-dark font-semibold mb-2">Repeat Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" required 
                                    class="w-full px-4 py-3 bg-white border border-brown-dark/20 rounded-lg focus:outline-none focus:ring-2 focus:ring-brown-dark focus:border-brown-dark">
                            </div>
                        </div>

                        <!-- Register Button 
                        <div class="pt-4">
                            <button type="submit" class="w-full bg-brown text-white font-bold py-4 px-6 rounded-lg hover:bg-brown-dark transition-colors duration-200 text-lg">
                                REGISTER NOW
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>