<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Reclaim Luggage - Track & Trace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        [x-cloak] { display: none !important; }
        .nav-item.active {
            background: rgba(139, 69, 19, 0.15);
            border-right: 3px solid #8B4513;
        }
        .form-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }
    </style>
</head>

<body style="background-image: url('/images/backgroundimg.jpeg'); background-size: cover;">
<div class="flex min-h-screen">
    @include('partials.staff-sidebar', ['active' => 'found-luggage'])

    <main class="flex-1 overflow-hidden">
        <header class="bg-white/80 backdrop-blur-sm border-b border-gray-200 px-8 py-4">
            <h1 class="text-2xl font-semibold text-[#55372c]">Reclaim Luggage</h1>
        </header>

        <div class="p-8 max-w-3xl mx-auto">
            <div class="bg-white/90 rounded-2xl shadow-md p-6 form-card">
                <h2 class="text-xl font-semibold mb-4 text-[#55372c]">Traveler & Luggage Details</h2>

                <form action="{{ route('staff.reclaim.sendOtp', ['luggage' => $luggage->id]) }}" method="POST" class="space-y-4">
                    @csrf

                    {{-- Luggage Info --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium text-[#55372c]">Luggage ID</label>
                            <input type="text" value="{{ $luggage->id }}" disabled class="w-full border rounded px-3 py-2 bg-gray-100" />
                        </div>
                        <div>
                            <label class="block font-medium text-[#55372c]">Brand / Type</label>
                            <input type="text" value="{{ $luggage->brand_type }}" disabled class="w-full border rounded px-3 py-2 bg-gray-100" />
                        </div>
                        <div>
                            <label class="block font-medium text-[#55372c]">Color</label>
                            <input type="text" value="{{ $luggage->color }}" disabled class="w-full border rounded px-3 py-2 bg-gray-100" />
                        </div>
                        <div>
                            <label class="block font-medium text-[#55372c]">Unique Features</label>
                            <input type="text" value="{{ $luggage->unique_features }}" disabled class="w-full border rounded px-3 py-2 bg-gray-100" />
                        </div>
                    </div>

                    {{-- Collector Info --}}
                    <h3 class="text-lg font-semibold mt-4 text-[#55372c]">Collector Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                        <div>
                            <label class="block font-medium text-[#55372c]">Name <span class="text-red-500">*</span></label>
                            <input type="text" name="collector_name" required class="w-full border rounded px-3 py-2" placeholder="Collector Name" />
                        </div>
                        <div>
                            <label class="block font-medium text-[#55372c]">ID Type <span class="text-red-500">*</span></label>
                            <input type="text" name="collector_id_type" required class="w-full border rounded px-3 py-2" placeholder="Passport / ID Card" />
                        </div>
                        <div>
                            <label class="block font-medium text-[#55372c]">ID Number <span class="text-red-500">*</span></label>
                            <input type="text" name="collector_id_number" required class="w-full border rounded px-3 py-2" placeholder="ID / Passport Number" />
                        </div>
                        <div>
                            <label class="block font-medium text-[#55372c]">Contact</label>
                            <input type="text" name="collector_contact" class="w-full border rounded px-3 py-2" placeholder="Phone / Email" />
                        </div>
                        <div class="md:col-span-2">
                            <label class="block font-medium text-[#55372c]">Relationship</label>
                            <input type="text" name="relationship" class="w-full border rounded px-3 py-2" placeholder="Relationship to Traveler" />
                        </div>
                    </div>

                    {{-- Terms --}}
                    <div class="mt-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="agree_terms" required class="form-checkbox" />
                            <span class="ml-2 text-[#55372c] text-sm">
                                I agree to the terms and confirm all information provided is correct.
                            </span>
                        </label>
                    </div>

                    {{-- Submit --}}
                    <div class="mt-4">
                        <button type="submit" class="w-full py-3 px-6 bg-[#55372c] text-[#edede1] font-semibold rounded-full hover:opacity-90 transition">
                            Send OTP
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

@include('partials.footer')
</body>
</html>
