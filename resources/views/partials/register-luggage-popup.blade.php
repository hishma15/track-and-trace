
<!-- Register Luggages -->                        
<div x-data="{ openModal: false }">
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
                                <!-- <div
                                    x-show="openModal"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0"
                                    x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition ease-in duration-200"
                                    x-transition:leave-start="opacity-100"
                                    x-transition:leave-end="opacity-0"
                                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                                > -->
                                <div
                                    x-show="openModal"
                                    class="fixed inset-0 flex items-center justify-center z-50"
                                    style="background-color: rgba(0, 0, 0, 0.70);"
                                >
                                    <!-- Modal Content -->
                                    <div class="bg-white p-6 rounded-lg shadow-xl max-w-2xl w-full relative" style="background-image: url('/images/backgroundimg.jpeg'); background-size: cover; background-position: center;">
                                        <button @click="openModal = false" class="absolute top-2 right-4 text-gray-500 text-2xl hover:text-gray-700 cursor-pointer">&times;</button>

                                        <h1 class="text-2xl font-normal mb-6" style="color: #55372c;">Register New Luggage</h1>

                                        <!-- Intro Section (like brown top box) -->
                                        <div class="rounded-t-xl p-6 flex justify-between items-center mb-4" style="background-color: #55372c; color: #edede1;">
                                            <div>
                                                <h2 class="text-xl font-bold">Luggage Registration</h2>
                                                <p class="text-sm">Provide details to help recover your luggage in case of loss.</p>
                                            </div>
                                            <!-- Optional: You can place an image here -->
                                            <!-- <img src="{{ asset('images/luggage-icon.png') }}" alt="Luggage" class="w-24 h-auto"> -->
                                        </div>

                                        <form action="{{ route('luggage.store') }}" method="POST" enctype="multipart/form-data" class="rounded-b-xl p-6 shadow space-y-4 bg-[#edede1]/45">
                                            @csrf

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block font-medium">Image</label>
                                                    <input type="file" name="image_path" class="w-full border rounded px-3 py-2" />
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

                                            <button type="submit" class="w-full mt-4 py-3 text-white rounded-full" style="background-color: #55372c;">
                                                Submit
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

