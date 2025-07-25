<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>My Luggages - Track & Trace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')

    <!-- Alpine JS -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" />

    <style>
        .nav-item.active {
            background: rgba(139, 69, 19, 0.15);
            border-right: 3px solid #8B4513;
        }
        .luggage-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .welcome-card {
            background: linear-gradient(135deg, #8B4513 0%, #654321 100%);
        }
        
        /* .action-card {
            background: linear-gradient(135deg, #f0f8ff 0%, #e6f3ff 100%);
            border: 1px solid #e0e6ed;
            transition: all 0.3s ease;
        } */
        .action-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
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
        .search-box {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }
        .profile-avatar {
            background: linear-gradient(135deg, #87CEEB 0%, #4682B4 100%);
        }

    </style>
</head>

<body style="background-image: url('/images/backgroundimg.jpeg'); background-size: cover;">
    <div class="flex min-h-screen">
        
        {{-- Sidebar --}}
        @include('partials.traveler-sidebar', ['active' => 'my-luggages'])

        {{-- Main --}}

        <main class="flex-1 overflow-hidden">
            <!-- Header -->
            <header class="bg-white/80 backdrop-blur-sm border-b border-gray-200 px-8 py-4">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-semibold text-[#55372c]">My Luggages</h1>
                </div>
            </header>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-6 text-center">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Luggage Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 m-5 p-5 lg:grid-cols-3 gap-8">
    @forelse ($luggages as $luggage)
        <div class="bg-white/90 rounded-2xl overflow-hidden shadow-md luggage-card transition transform hover:scale-[1.01] relative flex flex-col justify-between">
            {{-- Image --}}
            <img src="{{ $luggage->image_path ? asset('storage/' . $luggage->image_path) : asset('images/noimage.png') }}"
                class="w-full h-48 object-contain bg-white rounded-t-2xl" alt="Luggage Image">

            {{-- Details & Buttons --}}
            <div class="flex flex-col justify-between flex-grow">
                <div class="p-5 space-y-2">
                    <p><strong>Color:</strong> {{ $luggage->color ?? 'None' }}</p>
                    <p><strong>Brand / Type:</strong> {{ $luggage->brand_type ?? 'None' }}</p>
                    <p><strong>Description:</strong> {{ $luggage->description ?? 'None' }}</p>
                    <p><strong>Features:</strong> {{ $luggage->unique_features ?? 'None' }}</p>
                </div>

                {{-- Buttons --}}
                <div class="mt-auto px-5 pb-5 flex flex-wrap gap-3 items-center">
                    <a href="#" class="bg-[#55372c] text-[#edede1] px-6 py-3 rounded-lg font-medium transition-all duration-200 hover:opacity-90 focus:outline-none focus:ring-4 focus:ring-gray-300">Update</a>

                    <a href="#" class="bg-[#55372c] text-[#edede1] px-6 py-3 rounded-lg font-medium transition-all duration-200 hover:opacity-90 focus:outline-none focus:ring-4 focus:ring-gray-300">Generate QR</a>

                    <form action="#" method="POST" onsubmit="return confirm('Delete this luggage?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800">
                            <i class="fas fa-trash-alt text-xl"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center bg-white/90 text-gray-600 rounded-2xl p-10 shadow-md">
            <p class="text-lg font-medium">You haven’t registered any luggages yet.</p>
        </div>
    @endforelse
</div>


            {{-- Action Buttons --}}
            <div class="m-10 flex flex-col md:flex-row justify-center gap-6">

                {{-- Register Luggage Popup Trigger --}}
                @include('partials.register-luggage-popup')

                <!-- Report Lost Luggage -->
                <div class="action-card rounded-2xl p-6 cursor-pointer bg-white/80 transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-20 h-20 bg-teal-100 rounded-xl flex items-center justify-center">
                            <img src="{{ asset('images/report.png') }}" alt="Report" class="w-12 h-17">
                        </div>
                        <div>
                        <h3 class="text-xl font-semibold text-gray-800">Report Lost Luggage</h3>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Footer -->
     @include('partials.footer')

</body>
</html>

