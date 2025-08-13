<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>My Luggages - Track & Trace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')

    {{-- Other meta tags and links --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        /* THIS IS THE CRUCIAL FIX for the flickering/flashing modal */
        [x-cloak] { display: none !important; }

        /* Other styles */
        .nav-item.active {
            background: rgba(139, 69, 19, 0.15);
            border-right: 3px solid #8B4513;
        }
        .luggage-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
    </style>
</head>

<body style="background-image: url('/images/backgroundimg.jpeg'); background-size: cover;">
    <div class="flex min-h-screen">
        
        @include('partials.traveler-sidebar', ['active' => 'my-luggages'])

        <main class="flex-1 overflow-hidden">
            <header class="bg-white/80 backdrop-blur-sm border-b border-gray-200 px-8 py-4">
                <h1 class="text-2xl font-semibold text-[#55372c]">My Luggages</h1>
            </header>

            @if(session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-3 rounded m-5 text-center" id="success-alert">
                    {{ session('success') }}
                </div>
            @endif

            <div x-data="{ openModalId: null }" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 m-5 p-5 gap-8">
    @forelse ($luggages as $luggage)
        <div class="bg-white/90 rounded-2xl overflow-hidden shadow-md luggage-card transition flex flex-col">
            
            <img src="{{ $luggage->image_path ? asset('storage/' . $luggage->image_path) : asset('images/noimage.png') }}"
                class="w-full h-48 object-contain bg-white rounded-t-2xl" alt="Luggage Image">

            <div class="p-5 space-y-2 flex-grow flex flex-col justify-between">
                <div>
                    <p><strong>Color:</strong> {{ $luggage->color ?? 'N/A' }}</p>
                    <p><strong>Brand / Type:</strong> {{ $luggage->brand_type ?? 'N/A' }}</p>
                    <p><strong>Description:</strong> {{ $luggage->description ?? 'N/A' }}</p>
                </div>
                
                <div class="mt-4">
    @if($luggage->isLost())
        <!-- Cancel Report button -->
        <form action="{{ route('luggage.cancelReport', ['luggage' => $luggage->id]) }}" method="POST" class="inline">
            @csrf
            @method('PUT')
            <button 
                type="submit"
                class="mt-3 px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition flex items-center"
            >
                <i class="fas fa-times-circle mr-2"></i>
                Cancel Report
            </button>
        </form>
                    @else
                        <button 
                            @click="openModalId = {{ $luggage->id }}"
                            class="mt-3 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition flex items-center"
                        >
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Mark as Lost
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center bg-white/90 text-gray-600 rounded-2xl p-10 shadow-md">
            <p class="text-lg font-medium">You haven't registered any luggages yet.</p>
        </div>
    @endforelse

    <!-- Modals outside the cards, but inside same Alpine scope -->
    @foreach ($luggages as $luggage)
        <div
            x-show="openModalId === {{ $luggage->id }}"
            x-transition
            x-cloak
            @click.outside="openModalId = null"
            class="fixed inset-0 flex items-center justify-center z-50"
            style="background-color: rgba(0, 0, 0, 0.7); display: none;"
        >
            <div class="relative p-6 rounded-xl shadow-xl w-full max-w-2xl mx-auto max-h-[90vh] overflow-y-auto"
                style="background-image: url('/images/backgroundimg.jpeg'); background-size: cover; background-position: center;">

                <button 
                    @click="openModalId = null" 
                    class="absolute top-2 right-4 text-gray-500 text-2xl hover:text-gray-700 cursor-pointer" 
                    aria-label="Close modal"
                >&times;</button>

                <h1 class="text-2xl font-normal mb-6" style="color: #55372c;">Report Lost Luggage</h1>

                <div class="rounded-t-xl p-6 flex justify-between items-center mb-4" style="background-color: #55372c; color: #edede1;">
                    <div>
                        <h2 class="text-xl font-bold">Please provide details</h2>
                        <p class="text-sm">Fill in the station and any comments about your lost luggage.</p>
                    </div>
                </div>

                <form action="{{ route('luggage.markLost', ['luggage' => $luggage->id]) }}" method="POST" class="rounded-b-xl p-6 shadow space-y-4 bg-[#edede1]/45">
                    @csrf
                    @method('PUT')

                    <div class="text-black">
                        <label for="lost_station_{{ $luggage->id }}" class="block font-medium mb-2">
                            Lost Station <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="lost_station"
                            id="lost_station_{{ $luggage->id }}"
                            required
                            class="w-full border rounded px-3 py-2"
                            placeholder="Enter the station where luggage was lost"
                        >
                    </div>

                    <div class="text-black">
                        <label for="comment_{{ $luggage->id }}" class="block font-medium mb-2">
                            Comment <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            name="comment"
                            id="comment_{{ $luggage->id }}"
                            required
                            class="w-full border rounded px-3 py-2"
                            placeholder="Add any additional details"
                        ></textarea>
                    </div>

                    <!-- Date & Time Lost -->
                    <div class="text-black">
                        <label for="date_lost_{{ $luggage->id }}" class="block font-medium mb-2">
                            Date & Time Lost <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="datetime-local" 
                            name="date_lost" 
                            id="date_lost_{{ $luggage->id }}" 
                            required
                            class="w-full border rounded px-3 py-2"
                            value="{{ old('date_lost') }}"
                        >
                    </div>

                    <button type="submit" class="w-full py-4 px-6 text-xl font-semibold rounded-full transition-all duration-200 hover:opacity-90 focus:outline-none focus:ring-4 focus:ring-gray-300" style="background-color: #55372c; color: #edede1;">
                        Submit Report
                    </button>
                </form>
            </div>
        </div>
    @endforeach
</div>

            
        </main>
    </div>

    @include('partials.footer')

    <script>
        setTimeout(() => {
            const alert = document.getElementById('success-alert');
            if (alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }
        }, 3000);
    </script>
</body>
</html>
