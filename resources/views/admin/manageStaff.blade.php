<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Staff - Track & Trace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Lustria&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

        <!--Icons from fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Alpine JS  -->
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
        .staff-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .action-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

    </style>
</head>

<body style="background-image: url('/images/backgroundimg.jpeg'); background-size: cover;">
    <div class="flex min-h-screen">
        @include('partials.admin-sidebar', ['active' => 'manage-staff'])


        <main class="flex-1 overflow-hidden">
            <header class="bg-white/80 backdrop-blur-sm border-b border-gray-200 px-8 py-4">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-semibold text-[#55372c]">Manage Staff</h1>

                </div>
            </header>

            
    

            <div x-data="registerStaffModal()">
                <!-- Button to open modal -->
                <button
                    @click="openModal = true"
                    class="bg-[#55372c] backdrop-blur-sm text-white px-6 py-3 w-1/2 m-2 flex justify-center items-center rounded-lg font-medium hover:bg-[#55372c]/90 transition"
                    type="button"
                >
                    Manage Staff
                </button>

                <!-- Include modal partial inside same scope -->
                @include('partials.register-staff-modal')
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                @forelse ($staffMembers as $member)
                    <div class="bg-white/90 rounded-2xl shadow-md staff-card transition">
                        <div class="w-full h-40 bg-gray-100 flex justify-center items-center rounded-t-2xl">
                            <i class="fa-solid fa-train text-gray-500 text-6xl"></i>
                        </div>
                        <div class="p-4">
                            <h2 class="text-lg font-semibold text-gray-800">{{ $member->first_name }} {{ $member->last_name }}</h2>
                            <p class="text-sm text-gray-600">{{ $member->email }}</p>
                            <p class="text-sm text-gray-600">{{ $member->phone_no }}</p>
                            <div class="mt-4 flex justify-between">
                                <a href="{{ route('admin.staff.profile.show', $member->staff->id) }}" 
                                   class="bg-[#55372c] text-white px-3 py-1 rounded-lg hover:bg-[#55372c]/90">
                                    Edit
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center bg-white/90 text-gray-600 rounded-2xl p-10 shadow-md">
                        <p class="text-lg font-medium">No staff members found.</p>
                    </div>
                @endforelse
            </div>
        </main>

    {{-- @include('partials.register-staff-modal') --}}

    </div>

    <script>
        // Auto-hide success messages
        setTimeout(() => {
            const alert = document.querySelector('.bg-green-100');
            if (alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => {
                    alert.remove();
                }, 500);
            }
        }, 3000);

        // Register Staff Modal Function
        function registerStaffModal() {
            return {
                openModal: {{ $errors->any() ? 'true' : 'false' }}, // Keep modal open if errors exist
            }
        }
    </script>
</body>
</html>
