<!-- Modal Background Overlay -->
<div
    x-show="openModal"
    x-transition
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
>
    <!-- Modal Container -->
    <div class="bg-[#edede1] rounded-lg max-w-4xl w-full max-h-[90vh] overflow-auto p-6 relative">
        <!-- Close Button -->
        <button
            @click="openModal = false"
            class="absolute top-4 right-4 text-gray-600 hover:text-gray-900 text-3xl font-bold"
            aria-label="Close modal"
        >&times;</button>

        <h2 class="text-2xl font-bold mb-6" style="color: #55372c;">Staff Registration Form</h2>

        <form action="{{ route('staff.register') }}" method="POST" class="space-y-6">
            @csrf

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 border border-red-300 p-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-100 text-green-700 border border-green-300 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-1 font-medium" style="color: #55372c;">First Name</label>
                    <input 
                        type="text" 
                        name="first_name" 
                        class="w-full border border-gray-300 rounded px-3 py-2 bg-white text-[#55372c]" 
                        required 
                        value="{{ old('first_name') }}"
                    >
                </div>

                <div>
                    <label class="block mb-1 font-medium" style="color: #55372c;">Last Name</label>
                    <input 
                        type="text" 
                        name="last_name" 
                        class="w-full border border-gray-300 rounded px-3 py-2 bg-white text-[#55372c]" 
                        required 
                        value="{{ old('last_name') }}"
                    >
                </div>

                <div>
                    <label class="block mb-1 font-medium" style="color: #55372c;">Email Address</label>
                    <input 
                        type="email" 
                        name="email" 
                        class="w-full border border-gray-300 rounded px-3 py-2 bg-white text-[#55372c]" 
                        required 
                        value="{{ old('email') }}"
                    >
                </div>

                <div>
                    <label class="block mb-1 font-medium" style="color: #55372c;">Phone Number</label>
                    <input 
                        type="text" 
                        name="phone_no" 
                        class="w-full border border-gray-300 rounded px-3 py-2 bg-white text-[#55372c]" 
                        required 
                        value="{{ old('phone_no') }}"
                    >
                </div>

                <div>
                    <label class="block mb-1 font-medium" style="color: #55372c;">Staff ID</label>
                    <input 
                        type="text" 
                        name="staff_official_id" 
                        class="w-full border border-gray-300 rounded px-3 py-2 bg-white text-[#55372c]" 
                        required 
                        value="{{ old('staff_official_id') }}"
                    >
                </div>

                <div class="text-black">
                    <label for="organization" class="block font-medium mb-2">
                        Organization <span class="text-red-500">*</span>
                    </label>
                    <select name="organization" id="organization"
                            required
                            class="w-full border rounded px-3 py-2">
                        <option value="" disabled {{ old('organization') ? '' : 'selected' }}>Select an organization</option>
                        <option value="Kandy Railway Station" {{ old('organization') == 'Kandy Railway Station' ? 'selected' : '' }}>Kandy Railway Station</option>
                        <option value="Colombo fort Railway Station" {{ old('organization') == 'Colombo fort Railway Station' ? 'selected' : '' }}>Colombo fort Railway Station</option>
                        <option value="Maradana Railway Station" {{ old('organization') == 'Maradana Railway Station' ? 'selected' : '' }}>Maradana Railway Station</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-1 font-medium" style="color: #55372c;">Position</label>
                    <input type="text" name="position" class="w-full border border-gray-300 rounded px-3 py-2 bg-white text-[#55372c]" 
                        required 
                         value="{{ old('position') }}">
                </div>
                <div>
                    <label class="block mb-1 font-medium" style="color: #55372c;">Username</label>
                    <input type="text" name="username" class="w-full border border-gray-300 rounded px-3 py-2 bg-white text-[#55372c]" 
                        required 
                         value="{{ old('username') }}">
                </div>

                <div>
                    <label class="block mb-1 font-medium" style="color: #55372c;">Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        class="w-full border border-gray-300 rounded px-3 py-2 bg-white text-[#55372c]" 
                        required
                    >
                </div>

                <div>
                    <label class="block mb-1 font-medium" style="color: #55372c;">Repeat Password</label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        class="w-full border border-gray-300 rounded px-3 py-2 bg-white text-[#55372c]" 
                        required
                    >
                </div>
            </div>

            <button 
                type="submit" 
                class="w-full mt-4 py-3 px-6 text-lg font-semibold rounded-full transition-all duration-200 hover:opacity-90 focus:outline-none focus:ring-4 focus:ring-gray-300"
                style="background-color: #55372c; color: #edede1;"
            >
                REGISTER NOW
            </button>
        </form>
    </div>
</div>