<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Luggage Details - Track & Trace</title>
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
        @include('partials.admin-sidebar', ['active' => 'dashboard'])

        <main class="flex-1 overflow-hidden">
            <header class="bg-white/80 backdrop-blur-sm border-b border-gray-200 px-8 py-4">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-semibold text-[#55372c]">Luggage Details</h1>
                </div>
            </header>

            <div class="p-8 overflow-y-auto max-w-4xl mx-auto">

    {{-- Luggage Info Section --}}
    <div class="rounded-xl bg-[#edede1]/90 shadow-md p-8 mb-8">
        <h2 class="text-xl font-semibold text-[#55372c] mb-6 border-b border-gray-300 pb-2">
            Luggage Info
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            
            {{-- Luggage Image --}}
            <div class="flex justify-center">
                <a href="{{ $luggage->image_path ? asset('storage/' . $luggage->image_path) : asset('images/noimage.png') }}" target="_blank">
                    <img src="{{ $luggage->image_path ? asset('storage/' . $luggage->image_path) : asset('images/noimage.png') }}"
                         alt="Luggage Image"
                         class="rounded-lg shadow-md max-h-64 object-contain bg-white p-3">
                </a>
            </div>

            {{-- Luggage Details --}}
            <div class="space-y-3 text-[#55372c]">
                <p>
                    <span class="font-medium">Luggage ID:</span> {{ $luggage->id }}
                </p>
                <p>
                    <span class="font-medium">Brand / Type:</span> {{ $luggage->brand_type ?? 'N/A' }}
                </p>
                <p>
                    <span class="font-medium">Color:</span> {{ $luggage->color ?? 'N/A' }}
                </p>
                <p>
                    <span class="font-medium">Unique features:</span> {{ $luggage->unique_features ?? 'N/A' }}
                </p>
            </div>

        </div>
    </div>

    {{-- Traveler Details Section --}}
    <div class="rounded-xl bg-[#edede1]/90 shadow-md p-8 space-y-6">
        <h2 class="text-xl font-semibold text-[#55372c] mb-6 border-b border-gray-300 pb-2">
            Reported Lost By
        </h2>

        <div class="space-y-3 text-[#55372c]">
            <p>
                <span class="font-medium">Traveler Name:</span> {{ $luggage->traveler->user->first_name ?? 'N/A' }} {{ $luggage->traveler->user->last_name ?? '' }}
            </p>
            <p>
                <span class="font-medium">Traveler Phone:</span> {{ $luggage->traveler->user->phone_no ?? 'N/A' }}
            </p>
            <p>
                <span class="font-medium">Date Marked as Lost:</span> {{ $luggage->updated_at ? $luggage->updated_at->format('d M Y, h:i A') : 'N/A' }}
            </p>
            <p>
                <span class="font-medium">Traveler Comment:</span> {{ $luggage->comment ?? 'No comment provided' }}
            </p>
        </div>
    </div>
</div>


        </main>
    </div>

    @include('partials.footer')
</body>
</html>
