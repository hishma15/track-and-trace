<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Found Luggages - Track & Trace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body style="background-image: url('/images/backgroundimg.jpeg'); background-size: cover;">
<div class="flex min-h-screen">
    @include('partials.traveler-sidebar', ['active' => 'found-luggage'])

    <main class="flex-1 overflow-hidden">
        <header class="bg-white/80 backdrop-blur-sm border-b border-gray-200 px-8 py-4">
            <h1 class="text-2xl font-semibold text-[#55372c]">Found Luggages</h1>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 m-5 p-5 gap-8">
            @forelse ($luggages as $luggage)
                <div class="bg-white/90 rounded-2xl overflow-hidden shadow-md transition flex flex-col">
                    <img src="{{ $luggage->image_path ? asset('storage/' . $luggage->image_path) : asset('images/noimage.png') }}"
                         class="w-full h-48 object-contain bg-white rounded-t-2xl" alt="Luggage Image">

                    <div class="p-5 space-y-2 flex-grow flex flex-col justify-between">
                        <div>
                            <p><strong>Color:</strong> {{ $luggage->color ?? 'N/A' }}</p>
                            <p><strong>Brand / Type:</strong> {{ $luggage->brand_type ?? 'N/A' }}</p>
                            <p><strong>Description:</strong> {{ $luggage->description ?? 'N/A' }}</p>
                            <p><strong>Found Station:</strong> {{ $luggage->found_station ?? 'N/A' }}</p>
                            <p><strong>Date Found:</strong> {{ $luggage->date_found ?? 'N/A' }}</p>
                        </div>

                        <div class="mt-4">
                            <span class="inline-block px-4 py-2 bg-green-600 text-white rounded-lg">
                                Found
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center bg-white/90 text-gray-600 rounded-2xl p-10 shadow-md">
                    <p class="text-lg font-medium">No found luggages yet.</p>
                </div>
            @endforelse
        </div>
    </main>
</div>

@include('partials.footer')
</body>
</html>
