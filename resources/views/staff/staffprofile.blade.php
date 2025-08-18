<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Staff Profile - Track & Trace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    @vite('resources/css/app.css')

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Lustria&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet" />

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
        @include('partials.staff-sidebar', ['active' => 'profile'])

        <main class="flex-1 overflow-hidden">
            <header class="bg-white/80 backdrop-blur-sm border-b border-gray-200 px-8 py-4">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-semibold text-[#55372c]">Staff Profile</h1>
                </div>
            </header>

            @if(session('password_success'))
            <div class="bg-green-100 text-green-700 border border-green-300 p-3 rounded mb-4 max-w-md mx-auto mt-6">
                {{ session('password_success') }}
            </div>
            @endif

            @if(session('success'))
            <div class="bg-green-100 text-green-700 border border-green-300 p-3 rounded mb-4 max-w-md mx-auto mt-6">
                {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('staff.profile.update', $staff->id) }}" method="POST" class="rounded-b-xl p-6 shadow space-y-4 bg-[#edede1]/45">
                @csrf

                <div class="p-8 overflow-y-auto max-w-4xl mx-auto">
                    <div class="rounded-xl bg-[#edede1]/90 shadow-md p-8 space-y-6">

                        <div class="text-center mb-6">
                            <h2 class="text-3xl font-bold text-[#55372c]">{{ $staff->user->first_name }} {{ $staff->user->last_name }}</h2>
                            <p class="text-lg text-[#8B4513] font-medium">{{ $staff->position ?? 'Position not set' }}</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-[#55372c]">
                            <div>
                                <label class="block mb-1 font-medium" style="color: #55372c;">First Name</label>
                                <input type="text" name="first_name" value="{{ old('first_name', $staff->user->first_name) }}" disabled class="w-full border rounded px-3 py-2 bg-gray-100 cursor-not-allowed">
                                @error('first_name')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block mb-1 font-medium" style="color: #55372c;">Last Name</label>
                                <input type="text" name="last_name" value="{{ old('last_name', $staff->user->last_name) }}" disabled class="w-full border rounded px-3 py-2 bg-gray-100 cursor-not-allowed">
                                @error('last_name')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block mb-1 font-medium" style="color: #55372c;">Email</label>
                                <input type="text" name="email" value="{{ old('email', $staff->user->email) }}" disabled class="w-full border rounded px-3 py-2 bg-gray-100 cursor-not-allowed">
                                @error('email')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block mb-1 font-medium" style="color: #55372c;">Username</label>
                                <input type="text" name="username" value="{{ old('username', $staff->user->username) }}" disabled class="w-full border rounded px-3 py-2 bg-gray-100 cursor-not-allowed">
                                @error('username')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block mb-1 font-medium" style="color: #55372c;">Phone number</label>
                                <input type="text" name="phone_no" value="{{ old('phone_no', $staff->user->phone_no) }}" disabled class="w-full border rounded px-3 py-2 bg-gray-100 cursor-not-allowed">
                                @error('phone_no')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block mb-1 font-medium" style="color: #55372c;">Organization</label>
                                <input type="text" name="organization" value="{{ old('organization', $staff->organization) }}" disabled class="w-full border rounded px-3 py-2 bg-gray-100 cursor-not-allowed">
                                @error('organization')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block mb-1 font-medium" style="color: #55372c;">Position</label>
                                <input type="text" name="position" value="{{ old('position', $staff->position) }}" disabled class="w-full border rounded px-3 py-2 bg-gray-100 cursor-not-allowed">
                                @error('position')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block mb-1 font-medium" style="color: #55372c;">Staff official Id</label>
                                <input type="text" name="staff_official_id" value="{{ old('staff_official_id', $staff->staff_official_id) }}" disabled class="w-full border rounded px-3 py-2 bg-gray-100 cursor-not-allowed">
                                @error('staff_official_id')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        
                    </div>
                </div>
            </form>

            <hr class="my-8 border-gray-300" />

            @php
                $openPasswordPopup = $errors->has('current_password') ||
                                     $errors->has('new_password') ||
                                     $errors->has('new_password_confirmation') ||
                                     session()->has('password_success');
            @endphp

            <div
                x-data="{ open: @json($openPasswordPopup), deleteOpen: false }"
                x-init="
                    if (@json(session()->has('password_success'))) {
                        setTimeout(() => open = false, 3000);
                    }
                "
                class="text-center"
            >
                <div class="flex justify-center gap-4 mb-6">
                    <button @click="open = true; deleteOpen = false" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded transition">
                        Change Password
                    </button>

                    <button @click="deleteOpen = true; open = false" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded transition">
                        Delete Account
                    </button>
                </div>

                <div
                    x-show="open"
                    x-cloak
                    class="fixed inset-0 flex items-center justify-center z-50"
                    style="background-color: rgba(0, 0, 0, 0.70);"
                >
                    <div
                        @click.away="open = false"
                        class="bg-[#edede1] rounded-lg shadow-lg max-w-md w-full p-6"
                    >
                        <h2 class="text-xl font-bold mb-4 text-[#55372c]">
                            Change Password
                        </h2>

                        <form
                            action="{{ route('staff.profile.updatePassword', $staff->id) }}"
                            method="POST"
                            class="space-y-4"
                        >
                            @csrf

                            <div>
                                <label
                                    for="current_password"
                                    class="block font-medium text-[#55372c] mb-1"
                                >Current Password</label>
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
                                >New Password</label>
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
                                >Confirm New Password</label>
                                <input
                                    id="new_password_confirmation"
                                    name="new_password_confirmation"
                                    type="password"
                                    required
                                    minlength="6"
                                    class="w-full border border-gray-300 rounded px-3 py-2"
                                />
                            </div>

                            <div class="flex justify-end gap-2 mt-4">
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

                <div
                    x-show="deleteOpen"
                    x-cloak
                    class="fixed inset-0 flex items-center justify-center z-50"
                    style="background-color: rgba(0, 0, 0, 0.70);"
                >
                    <div
                        @click.away="deleteOpen = false"
                        class="bg-[#edede1] rounded-lg shadow-lg max-w-md w-full p-6"
                    >
                        <h2 class="text-xl font-bold mb-4 text-[#55372c]">
                            Confirm Delete Account
                        </h2>
                        <p class="mb-6 text-gray-700">
                            Are you sure you want to delete your account? This action cannot be undone.
                        </p>

                        <form method="POST" action="{{ route('staff.profile.destroy', $staff->id) }}">
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
        </main>
    </div>

    @include('partials.footer')
</body>
</html>
