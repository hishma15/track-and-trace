<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Notification Details - Track & Trace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    @vite('resources/css/app.css')

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Lustria&family=Montserrat:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        .nav-item { transition: all 0.3s ease; }
        .nav-item:hover { background: rgba(139, 69, 19, 0.1); transform: translateX(5px); }
        .nav-item.active { background: rgba(139, 69, 19, 0.15); border-right: 3px solid #8B4513; }
    </style>
</head>
<body class="min-h-screen"
      style="background-image: url('/images/backgroundimg.jpeg'); background-size: cover; background-position: center;">
<div class="flex min-h-screen">
    @include('partials.traveler-sidebar', ['active' => 'notifications'])

    <main class="flex-1 overflow-hidden">
        <header class="bg-white/80 backdrop-blur-sm border-b border-gray-200 px-8 py-4">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold text-[#55372c]">Notification Details</h1>
            </div>
        </header>

        <div class="p-8 overflow-y-auto max-w-4xl mx-auto">

            {{-- Notification Info --}}
            <div class="rounded-xl bg-[#edede1]/90 shadow-md p-8 mb-8">
                <h2 class="text-xl font-semibold text-[#55372c] mb-6 border-b border-gray-300 pb-2">
                    Notification Info
                </h2>
                <div class="space-y-3 text-[#55372c]">
                    <p><span class="font-medium">Title:</span> {{ $notification->title }}</p>
                    <p><span class="font-medium">Message:</span> {{ $notification->message }}</p>
                    <p><span class="font-medium">Received At:</span> {{ $notification->created_at->format('d M Y, h:i A') }}</p>
                </div>
            </div>

            {{-- Luggage Info --}}
            <div class="rounded-xl bg-[#edede1]/90 shadow-md p-8 mb-8">
                <h2 class="text-xl font-semibold text-[#55372c] mb-6 border-b border-gray-300 pb-2">
                    Luggage Info
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                    <div class="flex justify-center">
                        <a href="{{ $luggage->image_path ? asset('storage/' . $luggage->image_path) : asset('images/noimage.png') }}" target="_blank">
                            <img src="{{ $luggage->image_path ? asset('storage/' . $luggage->image_path) : asset('images/noimage.png') }}"
                                 alt="Luggage Image"
                                 class="rounded-lg shadow-md max-h-64 object-contain bg-white p-3">
                        </a>
                    </div>

                    <div class="space-y-3 text-[#55372c]">
                        <p><span class="font-medium">Luggage ID:</span> {{ $luggage->id }}</p>
                        <p><span class="font-medium">Brand / Type:</span> {{ $luggage->brand_type ?? 'N/A' }}</p>
                        <p><span class="font-medium">Color:</span> {{ $luggage->color ?? 'N/A' }}</p>
                        <p><span class="font-medium">Unique Features:</span> {{ $luggage->unique_features ?? 'N/A' }}</p>
                        <p><span class="font-medium">Status:</span> {{ ucfirst($luggage->status) }}</p>
                    </div>
                </div>
            </div>

            {{-- Staff Info --}}
            {{-- Scanned By --}}
<div class="rounded-xl bg-[#edede1]/90 shadow-md p-8">
    <h2 class="text-xl font-semibold text-[#55372c] mb-6 border-b border-gray-300 pb-2">
        Scanned By
    </h2>

    @if($staffUser)
        <div class="space-y-3 text-[#55372c]">
            <p><span class="font-medium">Staff Name:</span> {{ $staffUser->full_name }}</p>
            <p><span class="font-medium">Staff Email:</span> {{ $staffUser->email }}</p>
            <p><span class="font-medium">Staff Phone:</span> {{ $staffUser->phone_no ?? 'N/A' }}</p>
            <p><span class="font-medium">Organization:</span> {{ $staff->organization ?? 'N/A' }}</p>
            <p><span class="font-medium">Position:</span> {{ $staff->position ?? 'N/A' }}</p>
        </div>
    @else
        <p>No staff information available.</p>
    @endif
</div>



        </div>
    </main>
</div>

@include('partials.footer')
</body>
</html>
