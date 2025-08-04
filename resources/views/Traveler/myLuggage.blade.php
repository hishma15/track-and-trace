<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>My Luggages - Track & Trace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Lustria&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

        <!--Icons from fontawsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Alpine JS  -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

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

            {{-- Action Buttons --}}
            <div class="m-5 flex flex-col md:flex-row justify-center gap-6">

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

            
            {{-- Luggage Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 m-5 p-5 gap-8">
                @forelse ($luggages as $luggage)
                    <div x-data="{ openModal{{ $luggage->id }}: false }" class="bg-white/90 rounded-2xl overflow-hidden shadow-md luggage-card transition transform hover:scale-[1.01] relative flex flex-col justify-between">

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
                            <div class="mt-auto px-5 pb-5 flex flex-wrap gap-3 justify-between items-center">
                                <!-- Update Button -->
                                <button @click="$dispatch('open-update-{{ $luggage->id }}')"
                                    class="bg-[#55372c] text-[#edede1] px-6 py-3 rounded-lg font-medium transition-all duration-200 hover:opacity-90 focus:outline-none focus:ring-4 focus:ring-gray-300">
                                    Update
                                </button>


                                <!-- QR and Delete -->
                                <a href="#"
                                    class="bg-[#55372c] text-[#edede1] px-6 py-3 rounded-lg font-medium transition-all duration-200 hover:opacity-90 focus:outline-none focus:ring-4 focus:ring-gray-300">
                                    Generate QR
                                </a>

                                <form action="{{ route('luggage.destroy', $luggage->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this luggage?');">
                                    @csrf
                                    @method('DELETE')
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

            @foreach ($luggages as $luggage)
            <div 
            x-data="{ isOpen: false }" 
            x-on:open-update-{{ $luggage->id }}.window="isOpen = true"
            x-cloak
            >
                <div 
                    x-show="isOpen"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/70"
                >
                    <!-- Modal Box -->
                    <div 
                        @click.away="isOpen = false"
                        class="p-6 rounded-xl shadow-xl w-full max-w-2xl mx-auto relative max-h-[90vh] overflow-y-auto"
                        style="background-image: url('/images/backgroundimg.jpeg'); background-size: cover; background-position: center;"
                    >
                        <!-- Close Button -->
                        <button 
                            @click="isOpen = false"
                            class="absolute top-2 right-4 text-gray-500 text-2xl hover:text-gray-700 cursor-pointer"
                        >&times;</button>


                        <h2 class="text-2xl mb-4 font-semibold text-[#55372c]">Update Luggage</h2>

                        <div class="rounded-t-xl p-6 flex justify-between items-center mb-4" style="background-color: #55372c; color: #edede1;">
                            <div>
                                <h2 class="text-xl font-bold">Luggage Update</h2>
                                <p class="text-sm">Modify your luggage details to keep information up to date.</p>
                            </div>
                        </div>

                        <!-- Update Form -->
                        <form action="{{ route('luggage.update', $luggage->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-[#edede1]/60 p-6 rounded-lg">
                                    @csrf
                                    @method('PUT')

                                    <!-- Two Column Layout -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Left Column -->
                                        <div class="space-y-4">
                                            <div>
                                                <label class="block font-medium">Brand / Type</label>
                                                <input type="text" name="brand_type" value="{{ $luggage->brand_type }}" required class="w-full border rounded px-3 py-2" />
                                            </div>

                                            <div>
                                                <label class="block font-medium">Color</label>
                                                <input type="text" name="color" value="{{ $luggage->color }}" required class="w-full border rounded px-3 py-2" />
                                            </div>

                                            <div>
                                                <label class="block font-medium">Upload New Image</label>
                                                <input type="file" name="image_path" class="w-full border rounded px-3 py-2 bg-white" />
                                            </div>
                                        </div>

                                        <!-- Right Column -->
                                        <div class="space-y-4">


                                            <div>
                                                <label class="block font-medium">Current Image</label>
                                                @if ($luggage->image_path)
                                                    <img src="{{ asset('storage/' . $luggage->image_path) }}" class="max-w-full h-auto rounded-lg shadow-md border" alt="Luggage Image" />
                                                @else
                                                    <p class="text-gray-500">No image available.</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                            <!-- Below Two Columns -->
                            <div class="space-y-4">
                                <div>
                                    <label class="block font-medium">Description</label>
                                    <textarea name="description" rows="3" class="w-full border rounded px-3 py-2">{{ $luggage->description }}</textarea>
                                </div>

                                <div>
                                    <label class="block font-medium">Unique Features</label>
                                    <textarea name="unique_features" rows="3" class="w-full border rounded px-3 py-2">{{ $luggage->unique_features }}</textarea>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end pt-4">
                                <button type="submit" class="w-full mt-4 py-3 text-white rounded-full" style="background-color: #55372c;">
                                    Update Luggage
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            @endforeach
            
        </main>
    </div>

    <!-- Footer -->
     @include('partials.footer')

     <script>
        setTimeout(() => {
            const alert = document.querySelector('.bg-green-100');
            if (alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';

                // Remove the element from DOM after fade-out
                setTimeout(() => {
                    alert.remove();
                }, 500); // wait for fade-out transition to finish
            }
        }, 2000);
    </script>

</body>
</html>

