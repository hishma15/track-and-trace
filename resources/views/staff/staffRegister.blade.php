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
        <!-- Wrapper Flex Container -->
    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="w-64 text-brown-800 p-6 flex flex-col justify-between" style="background-color: #dec9ae;">
            <div>
                <div class="text-2xl font-bold flex items-center gap-2 mb-10">
                    <img src="{{ asset('images/tntlogo.png') }}" alt="Logo" class="w-20 h-20">
                    <span style="color: #55372c; font-family: 'Anton', sans-serif;">Track N’ Trace</span>
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
                <!-- <img src="{{ asset('images/register-banner.png') }}" alt="Banner" class="w-24 h-auto"> -->
            </div>

            <form action="{{ route('staff.register') }}" method="POST" class="rounded-b-xl p-6 shadow space-y-4 bg-[#edede1]/45">
                @csrf

                @if ($errors->has('login'))
                    <div class="bg-red-100 text-red-700 border border-red-300 p-3 rounded mb-6 text-center">
                        {{ $errors->first('login') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="bg-green-100 text-green-700 border border-green-300 p-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Your form fields -->
                    <div>
                        <label class="block mb-1 font-medium" style="color: #55372c;">First Name</label>
                        <input type="text" name="first_name" class="w-full border rounded px-3 py-2" required>
                        @error('first_name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block mb-1 font-medium" style="color: #55372c;">Last Name</label>
                        <input type="text" name="last_name" class="w-full border rounded px-3 py-2" required>
                        @error('last_name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block mb-1 font-medium" style="color: #55372c;">Email Address</label>
                        <input type="email" name="email" class="w-full border rounded px-3 py-2" required>
                        @error('email_name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block mb-1 font-medium" style="color: #55372c;">Username</label>
                        <input type="text" name="username" class="w-full border rounded px-3 py-2" required>
                        @error('username')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block mb-1 font-medium" style="color: #55372c;">Phone Number</label>
                        <input type="text" name="phone_no" class="w-full border rounded px-3 py-2" required>
                        @error('phone_no')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block mb-1 font-medium" style="color: #55372c;">Staff ID</label>
                        <input type="text" name="staff_official_id" class="w-full border rounded px-3 py-2" required>
                        @error('staff_official_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block mb-1 font-medium" style="color: #55372c;">Password</label>
                        <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
                        @error('password')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block mb-1 font-medium" style="color: #55372c;">Repeat Password</label>
                        <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2" required>
                        @error('password_confirmation')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
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
