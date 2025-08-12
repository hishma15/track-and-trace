

<!--
<div
    x-show="openModal"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @keydown.escape.window="openModal = false"
    class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm flex items-center justify-center p-4 z-50"
    aria-labelledby="modal-title-{{ $luggage->id }}"
    role="dialog"
    aria-modal="true"
>
    <!-- Modal Panel --
    <div
        @click.outside="openModal = false"
        x-show="openModal"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="bg-white rounded-xl shadow-2xl p-8 w-full max-w-lg"
    >
        <h3 id="modal-title-{{ $luggage->id }}" class="text-xl font-semibold text-[#55372c] mb-4">Report Luggage as Lost</h3>
        <p class="mb-6 text-gray-600">Provide the last known location and date for your <strong>{{$luggage->color}} {{$luggage->brand_type}}</strong>.</p>
        
        <form action="{{ route('report.lost', $luggage->id) }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="last_seen_location_{{ $luggage->id }}" class="block text-sm font-medium text-gray-700">Last Seen Location (Airport/Hotel)</label>
                    <input type="text" id="last_seen_location_{{ $luggage->id }}" name="last_seen_location" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="last_seen_date_{{ $luggage->id }}" class="block text-sm font-medium text-gray-700">Last Seen Date</label>
                    <input type="date" id="last_seen_date_{{ $luggage->id }}" name="last_seen_date" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
            </div>
            <div class="mt-8 flex justify-end space-x-4">
                <button type="button" @click="openModal = false" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    Confirm Report
                </button>
            </div>
        </form>
    </div>
</div>