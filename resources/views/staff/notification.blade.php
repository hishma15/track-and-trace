<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Notifications - Track & Trace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        [x-cloak] { display: none !important; }
        .nav-item.active {
            background: rgba(139, 69, 19, 0.15);
            border-right: 3px solid #8B4513;
        }
        .notification-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
    </style>
</head>

<body style="background-image: url('/images/backgroundimg.jpeg'); background-size: cover;">
<div class="flex min-h-screen">
    @include('partials.staff-sidebar', ['active' => 'notifications'])

    <main class="flex-1 overflow-hidden">
        <header class="bg-white/80 backdrop-blur-sm border-b border-gray-200 px-8 py-4">
            <h1 class="text-2xl font-semibold text-[#55372c]">Notifications</h1>
        </header>

        <div class="m-5 p-5 space-y-6">
            @forelse($notifications as $notification)
                <div class="bg-white/90 rounded-2xl overflow-hidden shadow-md notification-card transition border-l-4 {{ $notification->is_read ? 'border-gray-300' : 'border-[#8B4513]' }}">
                    <div class="p-5 flex justify-between items-start">
                        <div>
                            <h2 class="text-lg font-semibold text-[#55372c]">{{ $notification->title }}</h2>

                            {{-- Traveler Comment --}}
                            @if($notification->luggage && $notification->luggage->comment)
                                <p class="text-gray-600 mt-2">
                                    <span class="font-medium">Traveler Comment:</span> {{ $notification->luggage->comment }}
                                </p>
                            @else
                                <p class="text-gray-600 mt-2">No comment provided by traveler.</p>
                            @endif
                        </div>

                        <div class="flex items-start space-x-2">
                            {{-- View Luggage --}}
                            @if($notification->luggage)
                                <a href="{{ route('luggage.show', $notification->luggage->id) }}" 
                                   class="bg-[#8B4513] hover:bg-[#a0522d] text-white px-3 py-1 rounded text-sm">
                                    View Luggage
                                </a>
                            @endif

                            {{-- Mark as Read --}}
                            @if(!$notification->is_read)
                                <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="GET">
                                    <button type="submit" 
                                            class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                                        Mark as Read
                                    </button>
                                </form>
                            @else
                                <span class="text-green-600 font-medium text-sm">Read</span>
                            @endif

                            {{-- Delete Notification --}}
                            <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this notification?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-bold text-xl">&times;</button>
                            </form>
                        </div>
                    </div>

                    <p class="text-xs text-gray-400 px-5 pb-3">{{ $notification->created_at->format('d M Y, H:i') }}</p>
                </div>
            @empty
                <div class="text-center bg-white/90 text-gray-600 rounded-2xl p-10 shadow-md">
                    <p class="text-lg font-medium">No notifications available.</p>
                </div>
            @endforelse
        </div>
    </main>
</div>

@include('partials.footer')
</body>
</html>
