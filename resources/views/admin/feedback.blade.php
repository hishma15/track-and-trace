<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Track & Trace</title>
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

<body class="min-h-screen"  style="background-image: url('/images/backgroundimg.jpeg'); background-size: cover; background-position: center;">
    <div class="flex min-h-screen">
        
        <!-- Sidebar -->
        @include('partials.admin-sidebar', ['active' => 'users'])

        <!-- Main Content -->
        <main class="flex-1 overflow-hidden">
            <!-- Header -->
            <header class="bg-white/80 backdrop-blur-sm border-b border-gray-200 px-8 py-4">
                <div class="flex items-center justify-between">

                    <h1 class="text-2xl font-semibold text-[#55372c]">View Traveler Feedbacks</h1>

                    
                    
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
                    <th class="px-6 py-3">#</th>
                    <th class="px-6 py-3">Traveler</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Subject</th>
                    <th class="px-6 py-3">Message</th>
                    <th class="px-6 py-3">Rating</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($feedbacks as $index => $feedback)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-3">{{ $index + 1 }}</td>
                        <td class="px-6 py-3">{{ $feedback->traveler->user->first_name }} {{ $feedback->traveler->user->last_name }}</td>
                        <td class="px-6 py-3">{{ $feedback->traveler->user->email }}</td>
                        <td class="px-6 py-3">{{ $feedback->subject ?? '-' }}</td>
                        <td class="px-6 py-3">{{ $feedback->message }}</td>
                        <td class="px-6 py-3">{{ $feedback->rating ?? '-' }}</td>
                        <td class="px-6 py-3">{{ $feedback->status }}</td>
                        <td class="px-6 py-3">
                            @if($feedback->status !== 'Responded')
                                <form action="{{ route('admin.feedback.respond', $feedback->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-[#55372c] text-white px-3 py-1 rounded hover:bg-[#55372c]/90">
                                        Send Thank You
                                    </button>
                                </form>
                            @else
                                <span class="text-green-600 font-semibold">Responded</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
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

                // Remove the element from DOM after fade-out
                setTimeout(() => {
                    alert.remove();
                }, 500); // wait for fade-out transition to finish
            }
        }, 2000);

    </script>
</body>

</html>