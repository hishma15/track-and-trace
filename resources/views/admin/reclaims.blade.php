<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Track & Trace - All Reclaimed Reports</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Lustria&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        .nav-item:hover { background: rgba(139,69,19,0.1); transform: translateX(5px); }
        .nav-item.active { background: rgba(139,69,19,0.15); border-right: 3px solid #8B4513; }
        table th, table td { text-align: left; }
    </style>
</head>
<body class="min-h-screen" style="background-image: url('/images/backgroundimg.jpeg'); background-size: cover; background-position: center;">
    <div class="flex min-h-screen">

        <!-- Sidebar -->
        @include('partials.admin-sidebar', ['active' => 'reclaims'])

        <!-- Main Content -->
        <main class="flex-1 overflow-hidden">
            <!-- Header -->
            <header class="bg-white/80 backdrop-blur-sm border-b border-gray-200 px-8 py-4">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-semibold text-[#55372c]">All Reclaimed Luggage Reports</h1>
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="p-8 overflow-y-auto">

                @if (session('success'))
                    <div class="bg-green-100 text-green-700 border border-green-300 p-3 rounded mb-4 text-center">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto bg-[#edede1] shadow-md rounded-lg">
                    <table class="min-w-full text-sm text-left text-gray-600">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                            <tr>
                                <th class="px-6 py-3">Luggage ID</th>
                                <th class="px-6 py-3">Traveler</th>
                                <th class="px-6 py-3">Collector</th>
                                <th class="px-6 py-3">Handled By</th>
                                <th class="px-6 py-3">Station</th>
                                <th class="px-6 py-3">Reclaimed At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reclaims as $reclaim)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-3">{{ $reclaim->luggage->id }}</td>
                                    <td class="px-6 py-3">{{ $reclaim->traveler->user->full_name }}</td>
                                    <td class="px-6 py-3">{{ $reclaim->collector_name }}</td>
                                    <td class="px-6 py-3">{{ $reclaim->user->staff->getFullNameAttribute() }}</td>
                                    <td class="px-6 py-3">{{ $reclaim->user->staff->organization }}</td>
                                    <td class="px-6 py-3">{{ $reclaim->reclaimed_at }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-3 text-center">No reclaimed luggage records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
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
                setTimeout(() => alert.remove(), 500);
            }
        }, 2000);
    </script>
</body>
</html>
