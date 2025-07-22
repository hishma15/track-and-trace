<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Traveler Profile - Track & Trace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    @vite('resources/css/app.css')

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Lustria&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />

    <!-- Icons from FontAwesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        .nav-item {
            transition: all 0.3s ease;
        }
        .nav-item:hover {
            background: rgba(139, 69, 19, 0.1);
            transform: translateX(5px);
        }
        .nav-item.active {
            background: rgba(139, 69, 19, 0.15);
            border-right: 3px solid #8B4513;
        }
    </style>
</head>
<body
    class="min-h-screen"
    style="background-image: url('/images/backgroundimg.jpeg'); background-size: cover; background-position: center;"
>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-72 shadow-lg" style="background-color: #dec9ae;">
            <div class="p-6">
                <!-- Logo -->
                <div>
                    <div class="text-2xl font-bold flex items-center gap-2 mb-10">
                        <img src="{{ asset('images/tntlogo.png') }}" alt="Logo" class="w-20 h-20" />
                        <span style="color: #55372c; font-family: 'Anton', sans-serif;">Track N’ <br /> Trace</span>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="space-y-2">
                    <a href="{{ route('traveler.travelerDashboard') }}" class="nav-item flex items-center gap-3 p-3 rounded-lg text-gray-700 font-medium">
                        <i class="fas fa-home w-5 h-5"></i> Dashboard
                    </a>

                    <a
                        href="#" class="nav-item flex items-center gap-3 p-3 rounded-lg text-gray-700 font-medium">
                        <i class="fas fa-suitcase-rolling w-5 h-5"></i> My Luggages
                    </a>

                    <a href="#" class="nav-item flex items-center gap-3 p-3 rounded-lg text-gray-700 font-medium">
                        <i class="fas fa-search w-5 h-5"></i> Lost Luggage
                    </a>

                    <a href="#" class="nav-item flex items-center gap-3 p-3 rounded-lg text-gray-700 font-medium">
                        <i class="fas fa-box-open w-5 h-5"></i> Found Luggage
                    </a>

                    <a href="#" class="nav-item flex items-center gap-3 p-3 rounded-lg text-gray-700 font-medium">
                        <i class="fas fa-file-alt w-5 h-5"></i> Total Reports
                    </a>

                    <a href="{{ route('traveler.profile.show') }}" class="nav-item active flex items-center gap-3 p-3 rounded-lg text-gray-700 font-medium">
                        <i class="fas fa-user w-5 h-5"></i> My Profile
                    </a>

                    <a href="#" class="nav-item flex items-center gap-3 p-3 rounded-lg text-gray-700 font-medium">
                        <i class="fas fa-bell w-5 h-5"></i> Notifications
                    </a>

                    <a href="#" class="nav-item flex items-center gap-3 p-3 rounded-lg text-gray-700 font-medium">
                        <i class="fas fa-info-circle w-5 h-5"></i> About Us
                    </a>

                    <a href="#" class="nav-item flex items-center gap-3 p-3 rounded-lg text-gray-700 font-medium">
                        <i class="fas fa-question-circle w-5 h-5"></i> Help & Support
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-hidden">
            <!-- Header -->
            <header class="bg-white/80 backdrop-blur-sm border-b border-gray-200 px-8 py-4">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-semibold text-[#55372c]">Traveler Profile</h1>
                </div>
            </header>

            <!-- Page Content -->
            <div class="p-8 overflow-y-auto">
                <!-- <div
                    class="rounded-2xl p-10 max-w-3xl mx-auto shadow-md"
                > -->


                <form action="{{ route('traveler.profile.update') }}" method="POST" class="rounded-b-xl p-6 shadow space-y-4 bg-[#edede1]/45">
                @csrf

                @if(session('success'))
                    <div class="bg-green-100 text-green-700 border border-green-300 p-3 rounded mb-4">
                    {{ session('success') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="block mb-1 font-medium" style="color: #55372c;">First Name</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" class="w-full border rounded px-3 py-2" required>
                        @error('first_name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block mb-1 font-medium" style="color: #55372c;">Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" class="w-full border rounded px-3 py-2" required>
                        @error('last_name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block mb-1 font-medium" style="color: #55372c;">Username</label>
                        <input type="text" name="username" value="{{ old('username', $user->username) }}" class="w-full border rounded px-3 py-2" required>
                        @error('username')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block mb-1 font-medium" style="color: #55372c;">Email Address (cannot change)</label>
                        <input type="email" name="email" value="{{ $user->email }}" disabled class="w-full border rounded px-3 py-2 bg-gray-100 cursor-not-allowed">
                    </div>

                    <div>
                        <label class="block mb-1 font-medium" style="color: #55372c;">Phone Number</label>
                        <input type="text" name="phone_no" value="{{ old('phone_no', $user->phone_no) }}" class="w-full border rounded px-3 py-2" required>
                        @error('phone_no')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block mb-1 font-medium" style="color: #55372c;">National ID (cannot change)</label>
                        <input type="text" name="national_id" value="{{ $traveler->national_id ?? '' }}" disabled class="w-full border rounded px-3 py-2 bg-gray-100 cursor-not-allowed">
                    </div>

                </div>

                    <button type="submit" class="w-full py-4 px-6 text-xl font-semibold rounded-full transition-all duration-200 hover:opacity-90 focus:outline-none focus:ring-4 focus:ring-gray-300" style="background-color: #55372c; color: #edede1;">
                        Update Profile
                    </button>
                </form>

                    <!-- Divider -->
                    <hr class="my-8 border-gray-300" />

                    @php
                        // Check if password related validation errors exist, to open popup automatically
                        $openPasswordPopup = $errors->has('current_password') ||
                            $errors->has('new_password') ||
                            $errors->has('new_password_confirmation');
                    @endphp

                    <!-- Password & Delete Buttons and Popups -->
                    <div x-data="{ open: @json($openPasswordPopup), deleteOpen: false }" class="text-center">
                        <div class="flex justify-center gap-4 mb-6">
                            <!-- Change Password Button -->
                            <button @click="open = true" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded transition">
                                Change Password
                            </button>

                            <!-- Delete Account Button -->
                            <button @click="deleteOpen = true" class="bg-gray-700 hover:bg-black text-white font-semibold py-2 px-6 rounded transition">
                                Delete Account
                            </button>
                        </div>

                        <!-- Password change modal -->
                        <div x-show="open" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                            <div
                                @click.away="open = false"
                                class="bg-white rounded-lg shadow-lg max-w-md w-full p-6"
                            >
                                <h2 class="text-xl font-bold mb-4 text-[#55372c]">
                                    Change Password
                                </h2>

                                <form
                                    action="{{ route('traveler.profile.updatePassword') }}"
                                    method="POST"
                                    class="space-y-4"
                                >
                                    @csrf

                                    <div>
                                        <label
                                            for="current_password"
                                            class="block font-medium text-[#55372c] mb-1"
                                            >Current Password</label
                                        >
                                        <input
                                            id="current_password"
                                            name="current_password"
                                            type="password"
                                            required
                                            class="w-full border border-gray-300 rounded px-3 py-2"
                                        />
                                        @error('current_password')
                                            <p class="text-red-600 text-sm mt-1">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label
                                            for="new_password"
                                            class="block font-medium text-[#55372c] mb-1"
                                            >New Password</label
                                        >
                                        <input
                                            id="new_password"
                                            name="new_password"
                                            type="password"
                                            required
                                            minlength="6"
                                            class="w-full border border-gray-300 rounded px-3 py-2"
                                        />
                                        @error('new_password')
                                            <p class="text-red-600 text-sm mt-1">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label
                                            for="new_password_confirmation"
                                            class="block font-medium text-[#55372c] mb-1"
                                            >Confirm New Password</label
                                        >
                                        <input
                                            id="new_password_confirmation"
                                            name="new_password_confirmation"
                                            type="password"
                                            required
                                            minlength="6"
                                            class="w-full border border-gray-300 rounded px-3 py-2"
                                        />
                                    </div>

                                    <div
                                        class="flex justify-end gap-2 mt-4"
                                    >
                                        <button
                                            type="button"
                                            @click="open = false"
                                            class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 transition"
                                        >
                                            Cancel
                                        </button>
                                        <button
                                            type="submit"
                                            class="px-4 py-2 rounded bg-red-600 hover:bg-red-700 text-white transition"
                                        >
                                            Update Password
                                        </button>

                                        
                                    </div>
                                </form>
                            </div>
                        </div>

                            <!-- Delete Account Modal -->
                        <div
                            x-show="deleteOpen"
                            x-cloak
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                        >
                            <div @click.away="deleteOpen = false" class="bg-white rounded-lg shadow-lg max-w-md w-full p-6">
                                <h2 class="text-xl font-bold mb-4 text-[#55372c]">
                                    Confirm Delete Account
                                </h2>
                                <p class="mb-6 text-gray-700">
                                    Are you sure you want to delete your account? This action cannot be undone.
                                </p>

                                <form method="POST" action="{{ route('traveler.profile.destroy') }}">
                                    @csrf
                                    @method('DELETE')

                                    <div class="flex justify-end gap-2">
                                        <button
                                            type="button"
                                            @click="deleteOpen = false"
                                            class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 transition"
                                        >
                                            Cancel
                                        </button>
                                        <button
                                            type="submit"
                                            class="px-4 py-2 rounded bg-red-600 hover:bg-red-700 text-white transition"
                                        >
                                            Delete Account
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                    <!-- End Password Popup -->
                <!-- </div> -->
            </div>
        </main>
    </div>
</body>
</html>



<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Traveler Profile - Track & Trace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-50 min-h-screen p-6">

    <div class="max-w-3xl mx-auto bg-white shadow-md rounded p-6">

        <h1 class="text-2xl font-bold mb-6 text-brown-800">Update Profile</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('traveler.profile.update') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block font-medium text-brown-800 mb-1" for="first_name">First Name</label>
                <input id="first_name" name="first_name" type="text" value="{{ old('first_name', $user->first_name) }}" required
                    class="w-full border border-gray-300 rounded px-3 py-2" />
                @error('first_name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-medium text-brown-800 mb-1" for="last_name">Last Name</label>
                <input id="last_name" name="last_name" type="text" value="{{ old('last_name', $user->last_name) }}" required
                    class="w-full border border-gray-300 rounded px-3 py-2" />
                @error('last_name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-medium text-brown-800 mb-1" for="username">Username</label>
                <input id="username" name="username" type="text" value="{{ old('username', $user->username) }}" required
                    class="w-full border border-gray-300 rounded px-3 py-2" />
                @error('username') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-medium text-brown-800 mb-1" for="email">Email Address (cannot change)</label>
                <input id="email" name="email" type="email" value="{{ $user->email }}" disabled
                    class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 cursor-not-allowed" />
            </div>

            <div>
                <label class="block font-medium text-brown-800 mb-1" for="phone_no">Phone Number</label>
                <input id="phone_no" name="phone_no" type="text" value="{{ old('phone_no', $user->phone_no) }}" required
                    class="w-full border border-gray-300 rounded px-3 py-2" />
                @error('phone_no') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block font-medium text-brown-800 mb-1" for="national_id">National ID (cannot change)</label>
                <input id="national_id" name="national_id" type="text" value="{{ $traveler->national_id ?? '' }}" disabled
                    class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100 cursor-not-allowed" />
            </div>

            <button type="submit"
                class="w-full bg-blue-300 hover:bg-brown-700 text-white font-semibold py-3 rounded transition">
                Update Profile
            </button>
        </form>

        <!-- Divider -->
        <!-- <hr class="my-8 border-gray-300" />

        @php
            // Check if password related validation errors exist, to open popup automatically
            $openPasswordPopup = $errors->has('current_password') || $errors->has('new_password') || $errors->has('new_password_confirmation');
        @endphp

        
        <!-- Button to open password change popup -->
<!-- <div x-data="{ open: @json($openPasswordPopup) }" class="text-center">
    <button @click="open = true" 
        class="inline-block bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded transition">
        Change Password
    </button>

    <!-- Password change modal -->
    <!-- <div x-show="open" x-cloak
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div @click.away="open = false" class="bg-white rounded-lg shadow-lg max-w-md w-full p-6">
            <h2 class="text-xl font-bold mb-4 text-brown-800">Change Password</h2>

            <form action="{{ route('traveler.profile.updatePassword') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="current_password" class="block font-medium text-brown-800 mb-1">Current Password</label>
                    <input id="current_password" name="current_password" type="password" required
                        class="w-full border border-gray-300 rounded px-3 py-2" />
                    @error('current_password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="new_password" class="block font-medium text-brown-800 mb-1">New Password</label>
                    <input id="new_password" name="new_password" type="password" required minlength="6"
                        class="w-full border border-gray-300 rounded px-3 py-2" />
                    @error('new_password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="new_password_confirmation" class="block font-medium text-brown-800 mb-1">Confirm New Password</label>
                    <input id="new_password_confirmation" name="new_password_confirmation" type="password" required minlength="6"
                        class="w-full border border-gray-300 rounded px-3 py-2" />
                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" @click="open = false" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 transition">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded bg-red-600 hover:bg-red-700 text-white transition">Update Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

    </div>
</body>
</html> --> 
