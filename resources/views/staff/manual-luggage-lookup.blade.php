<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manual Luggage Lookup - Track N' Trace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Vite CSS -->
    @vite('resources/css/app.css')
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        .bg-track-brown {
            background-color: #55372c;
            color: #edede1;
        }
        
        .text-track-brown {
            color: #55372c;
        }
        
        .border-track-brown {
            border-color: #55372c;
        }
        
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

        .unique-code-input {
            font-family: 'Courier New', monospace;
            font-size: 1.2rem;
            letter-spacing: 2px;
        }

        .code-format-hint {
            color: #666;
            font-size: 0.875rem;
            font-style: italic;
        }
    </style>
</head>
<body class="min-h-screen" style="background-image: url('/images/backgroundimg.jpeg'); background-size: cover; background-position: center;">

    <div class="flex min-h-screen">
        
        <!-- Sidebar -->
        @include('partials.staff-sidebar', ['active' => 'manual-lookup'])

        <!-- Main Content -->
        <main class="flex-1 overflow-hidden">

            <header class="bg-white/80 backdrop-blur-sm border-b border-gray-200 px-8 py-4">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-semibold text-[#55372c]">Report Found Luggage [Manual ID]</h1>
                </div>
            </header>

            <!-- Main Content -->
            <div class="p-8 overflow-y-auto">
                
                <!-- Alert Container -->
                <div id="alert-container" class="mb-6"></div>

                <!-- Intro Section -->
                <div class="rounded-t-xl p-6 flex justify-between items-center mb-4" style="background-color: #55372c; color: #edede1;">
                    <div>
                        <h2 class="text-xl font-bold">Enter Luggage Unique Code</h2>
                        <p class="text-sm">When QR codes don't work, you can use the luggage unique code to find the owner</p>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="max-w-4xl mx-auto px-6 py-3" x-data="manualLookup()">

                    <!-- Code Entry Section -->
                    <div class="bg-[#edede1] backdrop-blur-sm rounded-2xl p-8 mb-8">
                        
                        <div class="max-w-2xl mx-auto">
                            <div class="text-center mb-8">
                                <div class="w-32 h-32 bg-gray-100 rounded-2xl mx-auto mb-6 flex items-center justify-center">
                                    <i class="fas fa-keyboard text-6xl text-track-brown opacity-70"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-track-brown mb-2">Enter Unique Code</h3>
                                <p class="text-gray-600">Enter the unique code found on the luggage tag</p>
                            </div>

                            <!-- Code Input Form -->
                            <div class="space-y-6">
                                <div>
                                    <label class="block font-semibold text-track-brown text-lg mb-3">
                                        <i class="fas fa-barcode mr-2"></i>Luggage Unique Code
                                    </label>
                                    <input 
                                        type="text" 
                                        x-model="uniqueCode"
                                        @input="uniqueCode = uniqueCode.toLowerCase().replace(/[^a-z0-9]/g, '')"
                                        @keyup.enter="lookupLuggage()"
                                        class="unique-code-input w-full px-6 py-4 text-center border-2 border-gray-300 rounded-xl focus:border-track-brown focus:outline-none transition-colors"
                                        placeholder="e.g. djfe37242"
                                        maxlength="9"
                                    >
                                    <p class="code-format-hint mt-2 text-center">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Enter the unique alphanumeric luggage code
                                    </p>
                                </div>

                                <!-- Search Button -->
                                <div class="text-center">
                                    <button 
                                        @click="lookupLuggage()"
                                        :disabled="!uniqueCode.trim() || isLoading"
                                        class="px-12 py-4 bg-track-brown hover:opacity-90 text-white rounded-xl font-semibold text-lg transition-all transform hover:-translate-y-1 disabled:opacity-50 disabled:transform-none disabled:cursor-not-allowed"
                                    >
                                        <i class="fas fa-search mr-2"></i>
                                        <span x-text="isLoading ? 'Searching...' : 'Find Luggage'"></span>
                                    </button>
                                </div>

                                <!-- Code Format Example -->
                                <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-blue-400">
                                    <h4 class="font-semibold text-gray-700 mb-2">
                                        <i class="fas fa-lightbulb mr-1 text-yellow-500"></i>Where to find the code:
                                    </h4>
                                    <ul class="text-gray-600 text-sm space-y-1">
                                        <li>• Look for a sticker or tag on the luggage</li>
                                        <li>• Usually near the QR code or handle</li>
                                        <li>• Format: 4 letters followed by 5 numbers</li>
                                        <li>• Example: <span class="font-mono bg-gray-200 px-2 py-1 rounded">djfe37242</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Luggage Details Section -->
                    <div x-show="showLuggageDetails" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform translate-y-4"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         class="bg-[#edede1] backdrop-blur-sm rounded-2xl p-8 shadow-xl">
                        
                        <div class="bg-track-brown rounded-xl p-6 text-center mb-6">
                            <h2 class="text-2xl font-bold mb-2"><i class="fas fa-suitcase mr-2"></i> Luggage Found!</h2>
                            <p class="opacity-90">Please verify the details below and mark as found if correct</p>
                            <div class="mt-3">
                                <span class="inline-block px-4 py-2 bg-white/20 rounded-full text-sm font-mono">
                                    Code: <span x-text="luggageData?.luggage?.unique_code"></span>
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                            <!-- Luggage Image -->
                            <div class="text-center">
                                <img :src="luggageData?.luggage?.image_path || 'https://via.placeholder.com/250x250?text=No+Image'" 
                         :alt="'Luggage Image'"
                         class="w-full h-64 object-cover rounded-xl shadow-lg">
                            </div>

                            <!-- Luggage Info -->
                            <div class="lg:col-span-2 space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-track-brown">
                                        <div class="text-sm font-semibold text-track-brown mb-1">Color</div>
                                        <div class="text-gray-800" x-text="luggageData?.luggage?.color || '-'"></div>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-track-brown">
                                        <div class="text-sm font-semibold text-track-brown mb-1">Brand/Type</div>
                                        <div class="text-gray-800" x-text="luggageData?.luggage?.brand_type || '-'"></div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-track-brown">
                                    <div class="text-sm font-semibold text-track-brown mb-1">Description</div>
                                    <div class="text-gray-800" x-text="luggageData?.luggage?.description || 'No description provided'"></div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-track-brown">
                                    <div class="text-sm font-semibold text-track-brown mb-1">Unique Features</div>
                                    <div class="text-gray-800" x-text="luggageData?.luggage?.unique_features || 'No unique features listed'"></div>
                                </div>
                                <!-- Traveler's Lost Report Comment (if exists) -->
                                <div x-show="luggageData?.luggage?.comment" class="bg-yellow-50 rounded-lg p-4 border-l-4 border-yellow-400">
                                    <div class="text-sm font-semibold text-yellow-700 mb-1">
                                        <i class="fas fa-comment-alt mr-1"></i>Traveler's Lost Report Comment
                                    </div>
                                    <div class="text-gray-800" x-text="luggageData?.luggage?.comment || ''"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Traveler Details -->
                        <div class="bg-blue-50 rounded-xl p-6 mb-6">
                            <div class="text-center mb-4">
                                <h3 class="text-xl font-semibold text-track-brown"><i class="fas fa-user mr-2"></i>Traveler Contact Information</h3>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-white rounded-lg p-4">
                                    <div class="text-sm font-semibold text-track-brown mb-1">Full Name</div>
                                    <div class="text-gray-800" x-text="`${luggageData?.traveler?.first_name || ''} ${luggageData?.traveler?.last_name || ''}`.trim() || '-'"></div>
                                </div>
                                <div class="bg-white rounded-lg p-4">
                                    <div class="text-sm font-semibold text-track-brown mb-1">Phone Number</div>
                                    <div class="text-gray-800" x-text="luggageData?.traveler?.phone_no || '-'"></div>
                                </div>
                                <div class="bg-white rounded-lg p-4">
                                    <div class="text-sm font-semibold text-track-brown mb-1">Email Address</div>
                                    <div class="text-gray-800" x-text="luggageData?.traveler?.email || '-'"></div>
                                </div>
                                <div class="bg-white rounded-lg p-4">
                                    <div class="text-sm font-semibold text-track-brown mb-1">National ID</div>
                                    <div class="text-gray-800" x-text="luggageData?.traveler?.national_id || '-'"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Status and Actions -->
                        <div class="text-center">
                            <div class="text-sm font-semibold text-track-brown mb-2">Current Status</div>
                            <div class="inline-block px-6 py-3 rounded-full font-semibold text-lg mb-6"
                                 :class="{
                                     'bg-green-500 text-white': luggageData?.luggage?.status === 'Safe',
                                     'bg-red-500 text-white': luggageData?.luggage?.status === 'Lost',
                                     'bg-blue-500 text-white': luggageData?.luggage?.status === 'Found'
                                 }"
                                 x-text="luggageData?.luggage?.status || 'Unknown'">
                            </div>
                            
                            <div class="flex justify-center gap-4">
                                <button x-show="luggageData?.luggage?.status !== 'Found'"
                                        @click="showMarkFoundModal = true"
                                        :disabled="isProcessing"
                                        class="px-8 py-3 bg-green-500 hover:bg-green-600 text-white rounded-full font-semibold transition-all transform hover:-translate-y-1 disabled:opacity-50 disabled:transform-none">
                                    <i class="fas fa-check mr-2"></i>Mark as Found
                                </button>
                                <button @click="clearResults()"
                                        class="px-8 py-3 bg-gray-500 hover:bg-gray-600 text-white rounded-full font-semibold transition-all transform hover:-translate-y-1">
                                    <i class="fas fa-times mr-2"></i>Clear & Search Again
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Mark as Found Modal -->
<div 
    x-show="showMarkFoundModal"
    x-transition
    class="fixed inset-0 flex items-center justify-center z-50"
    style="background-color: rgba(0, 0, 0, 0.7);"
>
    <!-- Modal Content -->
    <div 
        class="relative p-6 rounded-xl shadow-xl w-full max-w-2xl mx-auto max-h-[90vh] overflow-y-auto"
        style="background-image: url('/images/backgroundimg.jpeg'); background-size: cover; background-position: center;"
        @click.stop
    >
        <!-- Close Button -->
        <button @click="showMarkFoundModal = false" 
                class="absolute top-2 right-4 text-gray-500 text-2xl hover:text-gray-700 cursor-pointer">&times;</button>

        <!-- Modal Title -->
        <h1 class="text-2xl font-normal mb-6" style="color: #55372c;">Mark Luggage as Found</h1>

        <!-- Top Banner -->
        <div class="rounded-t-xl p-6 flex justify-between items-center mb-4" style="background-color: #55372c; color: #edede1;">
            <div>
                <h2 class="text-xl font-bold">Add Found Luggage Details</h2>
                <p class="text-sm">Please provide where and when this luggage was found</p>
            </div>
        </div>

        <!-- Modal Body -->
        <div class="rounded-b-xl p-6 shadow space-y-4 bg-[#edede1]/45">
            
            <!-- Found Location -->
            <div>
                <label class="block font-medium text-lg text-[#55372c] mb-2">
                    <i class="fas fa-map-marker-alt mr-1"></i>Found Location <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       x-model="foundLocation"
                       class="w-full border rounded px-3 py-2 focus:border-[#55372c] focus:outline-none">
                <!-- <p class="text-xs text-gray-700 mt-1">Where exactly was this luggage found?</p> -->
            </div>

            <!-- Staff Comment -->
            <div>
                <label class="block font-medium text-lg text-[#55372c] mb-2">
                    <i class="fas fa-comment mr-1"></i>Staff Comment <span class="text-gray-500">(Optional)</span>
                </label>
                <textarea x-model="staffComment"
                          rows="3"
                          class="w-full border rounded px-3 py-2 focus:border-[#55372c] focus:outline-none resize-none"></textarea>
            </div>

            <!-- Current Date/Time -->
            <div class="bg-gray-50 rounded-lg p-3">
                <div class="text-sm font-semibold text-[#55372c] mb-1">
                    <i class="fas fa-clock mr-1"></i>Found Date & Time
                </div>
                <div class="text-gray-700" 
                     x-text="new Date().toLocaleString('en-US', {
                         year: 'numeric',
                         month: 'long', 
                         day: 'numeric',
                         hour: '2-digit',
                         minute: '2-digit',
                         hour12: true
                     })"></div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3 mt-6">
                <button @click="showMarkFoundModal = false"
                        class="flex-1 px-4 py-3 border-2 border-gray-700 text-gray-700 rounded-lg font-semibold hover:bg-gray-800 hover:text-gray-100 transition-colors">
                    <i class="fas fa-times mr-2"></i>Cancel
                </button>
                <button @click="confirmMarkAsFound()"
                        :disabled="isProcessing || !foundLocation.trim()"
                        class="flex-1 px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fas fa-check mr-2"></i>
                    <span x-text="isProcessing ? 'Processing...' : 'Confirm Found'"></span>
                </button>
            </div>
        </div>
    </div>
</div>

        
    </div>

            </div>
        
        </main>

    </div>

   
     <!-- Footer -->
     @include('partials.footer')
    
<script>
function manualLookup() {
    return {
        uniqueCode: '',        // initial code is empty
        isLoading: false,      // loading state for search button
        isProcessing: false,   // loading state for mark-as-found button
        showLuggageDetails: false,
        luggageData: null,
        foundLocation: '',
        staffComment: '',
        showMarkFoundModal: false,

        // Lookup luggage by unique code
        lookupLuggage() {
            

            this.isLoading = true;

            fetch(`/staff/manual-lookup/${this.uniqueCode}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    this.luggageData = data.luggage;
                    this.showLuggageDetails = true;
                } else {
                    this.luggageData = null;
                    this.showLuggageDetails = false;
                    alert(data.message || 'Luggage not found.');
                }
                this.isLoading = false;
            })
            .catch(err => {
                console.error(err);
                alert('Error fetching luggage data.');
                this.isLoading = false;
            });
        },

        // Clear search results
        clearResults() {
            this.uniqueCode = '';
            this.luggageData = null;
            this.showLuggageDetails = false;
        },

        // Mark luggage as found
        confirmMarkAsFound() {
    if (!this.foundLocation.trim()) return;

    this.isProcessing = true;

    fetch(`/staff/manual-lookup/mark-found/${this.luggageData.luggage.id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            location: this.foundLocation,
            comment: this.staffComment
        })
    })

    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Update local UI
            this.luggageData.luggage.status = 'Found';
            this.luggageData.luggage.date_found = new Date().toISOString();
            this.showMarkFoundModal = false;
            alert(data.message); // optional success notification
        } else {
            alert(data.message || 'Failed to mark luggage as found.');
        }
        this.isProcessing = false;
    })
    .catch(err => {
        console.error(err);
        alert('Error marking luggage as found.');
        this.isProcessing = false;
    });
}

    }
}
</script>


</body>
</html>