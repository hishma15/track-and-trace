<div x-data="{ openModal: {{ $errors->any() ? 'true' : 'false' }} }">
    <!-- Trigger Button -->
    <div class="action-card rounded-2xl p-6 cursor-pointer bg-white/80 transition-all" @click="openModal = true">
        <div class="flex items-center gap-4">
            <div class="w-20 h-20 bg-orange-100 rounded-xl flex items-center justify-center">
                <img src="{{ asset('images/luggage.png') }}" alt="Luggage" class="w-15 h-15">
            </div>
            <div>
                <span class="text-xl font-semibold text-gray-800">Register Luggage</span>
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

            <h1 class="text-2xl font-normal mb-6" style="color: #55372c;">Register New Luggage</h1>

            <div class="rounded-t-xl p-6 flex justify-between items-center mb-4" style="background-color: #55372c; color: #edede1;">
                <div>
                    <h2 class="text-xl font-bold">Luggage Registration</h2>
                    <p class="text-sm">Provide details to help recover your luggage in case of loss.</p>
                </div>
            </div>

            <form action="{{ route('luggage.store') }}" method="POST" enctype="multipart/form-data" class="rounded-b-xl p-6 shadow space-y-4 bg-[#edede1]/45">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium">Image</label>
                        <input type="file" name="image_path" class="w-full border rounded px-3 py-2" />
                         @error('image_path')
                        <div class="text-red-600 mt-1 text-sm font-semibold">
                            {{ $message }}
                        </div>
                    @enderror
                    </div>
                    <div>
                        <label class="block font-medium">Color <span class="text-red-500">*</span></label>
                        <input type="text" name="color" required class="w-full border rounded px-3 py-2" />
                    </div>
                    <div>
                        <label class="block font-medium">Brand / Type <span class="text-red-500">*</span></label>
                        <input type="text" name="brand_type" required class="w-full border rounded px-3 py-2" />
                    </div>
                    <div class="md:col-span-2">
                        <label class="block font-medium">Description</label>
                        <textarea name="description" class="w-full border rounded px-3 py-2"></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block font-medium">Unique Features</label>
                        <textarea name="unique_features" class="w-full border rounded px-3 py-2"></textarea>
                    </div>
                </div>

                <button type="submit" class="w-full py-4 px-6 text-xl font-semibold rounded-full transition-all duration-200 hover:opacity-90 focus:outline-none focus:ring-4 focus:ring-gray-300" style="background-color: #55372c; color: #edede1;">
                    Register Luggage
                </button>
            </form>
        </div>
    </div>
</div>
