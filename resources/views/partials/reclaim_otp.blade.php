@push('styles')
    @vite('resources/css/app.css')
@endpush


<div x-data="{ openModal: {{ $errors->any() ? 'true' : 'false' }} }">
    <!-- Trigger Button -->
    <div class="action-card rounded-2xl p-6 cursor-pointer bg-white/80 transition-all" @click="openModal = true">
        <div class="flex items-center gap-4">
            <div class="w-20 h-20 bg-orange-100 rounded-xl flex items-center justify-center">
                <img src="{{ asset('images/otp.png') }}" alt="OTP" class="w-15 h-15">
            </div>
            <div>
                <span class="text-xl font-semibold text-gray-800">Verify OTP</span>
            </div>
        </div>
    </div>

    <!-- Modal Background -->
    <div
        x-show="openModal"
        class="fixed inset-0 flex items-center justify-center z-50 bg-black/70"
        style="backdrop-filter: blur(3px);"
    >
        <!-- Modal Content -->
        <div
            @click.away="openModal = false"
            class="relative p-6 rounded-xl shadow-xl w-full max-w-2xl mx-auto max-h-[90vh] overflow-y-auto"
            style="background-image: url('/images/backgroundimg.jpeg'); background-size: cover; background-position: center;"
        >
            <!-- Close Button -->
            <button 
                @click="openModal = false"
                class="absolute top-2 right-4 text-gray-500 text-2xl hover:text-gray-700 cursor-pointer"
            >&times;</button>

            <!-- Modal Heading -->
            <h1 class="text-2xl font-normal mb-6" style="color: #55372c;">Verify OTP</h1>

            <!-- Section Header -->
            <div class="rounded-t-xl p-6 flex justify-between items-center mb-4" style="background-color: #55372c; color: #edede1;">
                <div>
                    <h2 class="text-xl font-bold">OTP Verification</h2>
                    <p class="text-sm">An OTP has been sent to your email. Enter it below to confirm luggage reclaim.</p>
                </div>
            </div>

            <!-- OTP Form -->
            <form action="{{ route('staff.reclaim.verifyOtp', ['reclaim' => $reclaim->id]) }}" method="POST" class="rounded-b-xl p-6 shadow space-y-4 bg-[#edede1]/45">
                @csrf
                <div>
                    <label class="block font-medium">OTP Code <span class="text-red-500">*</span></label>
                    <input type="number" name="otp" required class="w-full border rounded px-3 py-2" placeholder="Enter OTP" />
                    @error('otp')
                        <div class="text-red-600 mt-1 text-sm font-semibold">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" 
                    class="w-full py-4 px-6 text-xl font-semibold rounded-full transition-all duration-200 hover:opacity-90 focus:outline-none focus:ring-4 focus:ring-gray-300" 
                    style="background-color: #55372c; color: #edede1;">
                    Verify OTP
                </button>
            </form>

            <!-- Resend OTP -->
            <div class="mt-4">
                <form action="{{ route('staff.reclaim-resend-otp', ['reclaim' => $reclaim->id]) }}" method="POST">
                    @csrf
                    <button type="submit" 
                        class="w-full py-3 px-6 text-lg font-semibold rounded-full transition-all duration-200 hover:opacity-90 focus:outline-none focus:ring-4 focus:ring-gray-300" 
                        style="background-color: #55372c; color: #edede1;">
                        Resend OTP
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
