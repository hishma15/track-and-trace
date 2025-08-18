<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Lost Luggage Reports - Track & Trace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1/dayjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1/plugin/relativeTime.js"></script>
    <script> dayjs.extend(dayjs_plugin_relativeTime); </script>

    <style>
        [x-cloak] { display: none !important; }

        .nav-item.active {
            background: rgba(139, 69, 19, 0.15);
            border-right: 3px solid #8B4513;
        }

        .luggage-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .luggage-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .modal-content {
            background-image: url('/images/backgroundimg.jpeg');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body style="background-image: url('/images/backgroundimg.jpeg'); background-size: cover;">
<div class="flex min-h-screen" x-data="lostLuggageReports()">
    @include('partials.traveler-sidebar', ['active' => 'reports'])

    <main class="flex-1 overflow-hidden">
        <header class="bg-white/80 backdrop-blur-sm border-b border-gray-200 px-8 py-4">
            <h1 class="text-2xl font-semibold text-[#55372c]">Lost Luggage Reports</h1>
        </header>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 m-5 p-5 gap-8">
    @forelse ($luggages as $luggage)
        <div class="bg-white/90 rounded-2xl overflow-hidden shadow-md luggage-card flex flex-col">
            <img src="{{ $luggage->image_path ? asset('storage/' . $luggage->image_path) : asset('images/noimage.png') }}"
                 class="w-full h-48 object-contain bg-white rounded-t-2xl" alt="Luggage Image">

            <div class="p-5 space-y-2 flex-grow flex flex-col justify-between">
                <div>
                    <p><strong>Color:</strong> {{ $luggage->color ?? 'N/A' }}</p>
                    <p><strong>Brand / Type:</strong> {{ $luggage->brand_type ?? 'N/A' }}</p>
                    <p><strong>Description:</strong> {{ $luggage->description ?? 'N/A' }}</p>
                    <p><strong>Lost Station:</strong> {{ $luggage->lost_station ?? 'N/A' }}</p>
                    <p><strong>Date Lost:</strong> {{ $luggage->date_lost ?? 'N/A' }}</p>
                </div>

                <div class="mt-4 flex justify-between items-center">
                 
                    <button @click="fetchHistory({{ $luggage->id }})"
                            class="px-4 py-2 bg-[#8B4513] text-white rounded-lg hover:bg-[#a0522d] transition">
                        View Scan History
                    </button>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full text-center bg-white/90 text-gray-600 rounded-2xl p-10 shadow-md">
            <p class="text-lg font-medium">No lost luggage reports found.</p>
        </div>
    @endforelse
</div>

<!-- Scan History Modal -->
<div x-show="openModalId !== null" x-cloak
     class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-70">
    <div class="modal-content relative p-6 rounded-xl shadow-xl w-full max-w-2xl mx-auto max-h-[90vh] overflow-y-auto bg-white/95">
        <button @click="openModalId = null"
                class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-3xl font-bold">&times;</button>

        <h1 class="text-2xl font-semibold mb-4 text-[#55372c] text-center">Scan History</h1>

        <template x-if="history[openModalId] === null">
            <p class="text-gray-600 text-center">Loading...</p>
        </template>

        <template x-if="history[openModalId] && history[openModalId].length === 0">
            <p class="text-gray-600 text-center">No scan history available for this luggage.</p>
        </template>

        <template x-if="history[openModalId] && history[openModalId].length > 0">
            <ul class="space-y-3">
                <template x-for="log in history[openModalId]" :key="log.id">
                    <li class="border rounded-lg p-4 bg-white shadow-sm flex justify-between">
                        <div>
                            <p><strong>Action:</strong> <span x-text="log.action"></span></p>
                            <p><strong>Comment:</strong> <span x-text="log.comment || 'N/A'"></span></p>
                            <p><strong>Location:</strong> <span x-text="log.scan_location"></span></p>
                            <p><strong>Staff:</strong> <span x-text="log.staff?.name"></span> (<span x-text="log.staff?.email"></span>)</p>
                            
                        </div>
                        <div class="text-gray-500 text-sm flex flex-col items-end justify-between">
                            <p x-text="log.scan_datetime"></p> <!-- timestamp -->
                        </div>
                    </li>
                </template>
            </ul>
        </template>
    </div>
</div>

    </main>
</div>

@include('partials.footer')

<script>
function lostLuggageReports() {
    return {
        openModalId: null,
        history: {},
        fetchHistory(luggageId) {
            this.openModalId = luggageId;
            this.history[luggageId] = null;

            fetch(`/api/qr-scan/luggage/${luggageId}/history`)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.history[luggageId] = data.scan_logs.map(log => {
                            return {
                                ...log,
                                scan_datetime: dayjs(log.scan_datetime).fromNow()
                            }
                        });
                    } else {
                        this.history[luggageId] = [];
                        alert(data.message || 'No scan history available');
                    }
                })
                .catch(() => {
                    this.history[luggageId] = [];
                    alert('Failed to fetch scan history');
                });
        }
    }
}
</script>
</body>
</html>
