<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    <title>QR Code Scanner - Track N' Trace</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <!-- QR Scanner Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
    
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
        
        .scanner-frame {
            border: 3px solid #55372c;
            border-radius: 20px;
            position: relative;
        }
        
        .scanner-frame::before {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            border: 2px dashed #55372c;
            border-radius: 25px;
            opacity: 0.3;
        }
        
        #qr-reader {
            border-radius: 15px !important;
            overflow: hidden !important;
        }
        
        #qr-reader video {
            border-radius: 15px !important;
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
    </style>
</head>
<body class="min-h-screen"  style="background-image: url('/images/backgroundimg.jpeg'); background-size: cover; background-position: center;">

    <div class="flex min-h-screen">
        
        <!-- Sidebar -->
        @include('partials.staff-sidebar', ['active' => 'scan-qr'])

        <!-- Main Content -->
        <main class="flex-1 overflow-hidden">

            <header class="bg-white/80 backdrop-blur-sm border-b border-gray-200 px-8 py-4">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-semibold text-[#55372c]">Report Found Luggage [Scan QR Code]</h1>
                </div>
            </header>

            <!-- Main Content -->
            <div class="p-8 overflow-y-auto">
                @if (session('success'))
                <div class="bg-green-100 text-green-700 border border-green-300 p-3 rounded mb-4 text-center">
                    {{ session('success') }}
                </div>
                @endif

                <!-- Alert Container -->
                <div id="alert-container" class="mb-6"></div>

                <!-- Intro Section (like brown top box) -->
                <div class="rounded-t-xl p-6 flex justify-between items-center mb-4" style="background-color: #55372c; color: #edede1;">
                    <div>
                        <h2 class="text-xl font-bold">Scan QR Code</h2>
                        <p class="text-sm">Scan the luggage QR code to quickly retrieve its details and notify the owner.</p>
                    </div>
                </div>

                <!-- Main Content -->
    <div class="max-w-4xl mx-auto px-6 py-3" x-data="qrScanner()">

        <!-- QR Scanner Section -->
        <div class="bg-[#edede1] backdrop-blur-sm rounded-2xl p-8 mb-8">
            <div class="text-center mb-8">
                <!-- QR Code Display Area -->
                <div class="flex justify-center mb-6">
                    <div class="scanner-frame bg-gray-50 flex items-center justify-center" style="width: 300px; height: 300px;">
                        <div id="qr-reader" class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-500">
                            <div class="text-center">
                                <i class="fas fa-qrcode text-6xl mb-4 opacity-50"></i>
                                <p class="text-sm">QR Scanner will appear here</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Action Buttons -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Camera Scan Button -->
                <div class="bg-white rounded-xl p-6 border-2 border-gray-200 hover:border-track-brown transition-all cursor-pointer group" 
                     @click="toggleScanner()">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-orange-100 rounded-xl flex items-center justify-center group-hover:bg-orange-200 transition-colors">
                            <i class="fas fa-camera text-2xl text-track-brown"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800" x-text="isScanning ? 'Stop Scanner' : 'Scan QR Code'"></h3>
                            <p class="text-sm text-gray-600">Use camera to scan QR code</p>
                        </div>
                    </div>
                </div>

                <!-- Upload Image Button -->
                <div class="bg-white rounded-xl p-6 border-2 border-gray-200 hover:border-track-brown transition-all cursor-pointer group"
                     @click="$refs.fileInput.click()">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                            <i class="fas fa-upload text-2xl text-track-brown"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Upload Image</h3>
                            <p class="text-sm text-gray-600">Select QR code image from device</p>
                        </div>
                    </div>
                    <input type="file" x-ref="fileInput" @change="handleFileUpload($event)" accept="image/*" class="hidden">
                </div>
            </div>

            <!-- Camera Permissions Warning -->
            <div x-show="showCameraWarning" class="mt-6 bg-yellow-50 border-2 border-yellow-200 rounded-lg p-4 text-center">
                <div class="text-yellow-800">
                    <i class="fas fa-exclamation-triangle mb-2 text-lg"></i>
                    <p>Please allow camera access to use the QR scanner</p>
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
                    <!-- <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-track-brown">
                        <div class="text-sm font-semibold text-track-brown mb-1">Luggage ID</div>
                        <div class="text-gray-800" x-text="luggageData?.luggage?.id || '-'"></div>
                    </div> -->
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
                            @click="markAsFound()"
                            :disabled="isProcessing"
                            class="px-8 py-3 bg-green-500 hover:bg-green-600 text-white rounded-full font-semibold transition-all transform hover:-translate-y-1 disabled:opacity-50 disabled:transform-none">
                        <i class="fas fa-check mr-2"></i>Mark as Found
                    </button>
                    <button @click="cancelScan()"
                            class="px-8 py-3 bg-gray-500 hover:bg-gray-600 text-white rounded-full font-semibold transition-all transform hover:-translate-y-1">
                        <i class="fas fa-times mr-2"></i>Cancel
                    </button>
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
        function qrScanner() {
            return {
                isScanning: false,
                showCameraWarning: false,
                showLuggageDetails: false,
                luggageData: null,
                isProcessing: false,
                html5QrcodeScanner: null,

                async toggleScanner() {
                    if (this.isScanning) {
                        await this.stopScanner();
                    } else {
                        await this.startScanner();
                    }
                },

                async startScanner() {
                    try {
                        // Check camera permissions first
                        const stream = await navigator.mediaDevices.getUserMedia({ video: true });
                        stream.getTracks().forEach(track => track.stop());
                        this.showCameraWarning = false;

                        this.html5QrcodeScanner = new Html5Qrcode("qr-reader");
                        
                        const config = {
                            fps: 10,
                            qrbox: { width: 250, height: 250 },
                            aspectRatio: 1.0,
                            disableFlip: false,
                            videoConstraints: {
                                facingMode: "environment"
                            }
                        };

                        await this.html5QrcodeScanner.start(
                            { facingMode: "environment" },
                            config,
                            (decodedText) => this.onScanSuccess(decodedText),
                            (error) => this.onScanError(error)
                        );

                        this.isScanning = true;
                        this.showAlert('Scanner started successfully! Point camera at QR code', 'success');

                    } catch (err) {
                        console.error('Scanner start error:', err);
                        this.isScanning = false;
                        
                        if (err.name === 'NotAllowedError' || err.name === 'PermissionDeniedError') {
                            this.showCameraWarning = true;
                            this.showAlert('Camera permission denied. Please allow camera access and try again.', 'error');
                        } else {
                            this.showAlert('Error starting scanner: ' + (err.message || 'Unknown error'), 'error');
                        }
                    }
                },

                async stopScanner() {
                    if (this.html5QrcodeScanner && this.isScanning) {
                        try {
                            await this.html5QrcodeScanner.stop();
                            this.html5QrcodeScanner.clear();
                            this.html5QrcodeScanner = null;
                            this.isScanning = false;
                            this.showAlert('Scanner stopped', 'info');
                        } catch (err) {
                            console.error('Scanner stop error:', err);
                            this.isScanning = false;
                            this.showAlert('Scanner stopped (with warnings)', 'info');
                        }
                    } else {
                        this.isScanning = false;
                    }
                },

                async handleFileUpload(event) {
                    const file = event.target.files[0];
                    if (!file) return;

                    if (!file.type.startsWith('image/')) {
                        this.showAlert('Please select a valid image file', 'error');
                        return;
                    }

                    this.showAlert('Processing image...', 'info');
                    
                    try {
                        const html5QrCode = new Html5Qrcode("qr-reader");
                        const result = await html5QrCode.scanFile(file, true);
                        this.onScanSuccess(result);
                    } catch (err) {
                        console.error('File scan error:', err);
                        this.showAlert('Could not read QR code from image. Please try another image.', 'error');
                    }
                },

                onScanSuccess(decodedText) {
                    console.log('QR Code scanned:', decodedText);
                    
                    // Extract luggage ID from URL or direct ID
                    let luggageId = decodedText;
                    if (decodedText.includes('/')) {
                        const urlParts = decodedText.split('/');
                        luggageId = urlParts[urlParts.length - 1];
                    }
                    
                    if (luggageId && luggageId.trim()) {
                        if (this.isScanning) {
                            this.stopScanner();
                        }
                        this.fetchLuggageDetails(luggageId);
                    } else {
                        this.showAlert('Invalid QR code format', 'error');
                    }
                },

                onScanError(error) {
                    // Only log errors, don't show them as they're frequent while scanning
                },

                async fetchLuggageDetails(luggageId) {
                    this.showAlert('Fetching luggage details...', 'info');
                    
                    try {
                        const response = await fetch(`/api/qr-scan/luggage/${luggageId}`, {
                            method: 'GET',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        });

                        if (!response.ok) {
                            const errorData = await response.json();
                            throw new Error(errorData.message || `HTTP ${response.status}`);
                        }

                        const data = await response.json();
                        
                        if (data.success) {
                            this.luggageData = data;
                            this.showLuggageDetails = true;
                            this.showAlert('Luggage details loaded successfully!', 'success');
                        } else {
                            this.showAlert('Error: ' + (data.message || 'Unknown error occurred'), 'error');
                        }
                    } catch (error) {
                        console.error('API Error:', error);
                        this.showAlert('Error fetching luggage details: ' + error.message, 'error');
                    }
                },

                async markAsFound() {
                    if (!this.luggageData) return;

                    const comment = prompt('Add a comment (optional):') || '';
                    const location = prompt('Current location (optional):') || '';
                    
                    this.isProcessing = true;
                    this.showAlert('Marking luggage as found...', 'info');
                    
                    try {
                        const response = await fetch(`/api/qr-scan/luggage/${this.luggageData.luggage.id}/found`, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                comment: comment,
                                location: location
                            })
                        });

                        const data = await response.json();
                        
                        if (data.success) {
                            this.luggageData.luggage.status = 'Found';
                            this.showAlert('Luggage successfully marked as found! Owner will be notified.', 'success');
                        } else {
                            this.showAlert('Error: ' + (data.message || 'Failed to mark as found'), 'error');
                        }
                    } catch (error) {
                        console.error('Mark found API Error:', error);
                        this.showAlert('Error marking luggage as found: ' + error.message, 'error');
                    } finally {
                        this.isProcessing = false;
                    }
                },

                cancelScan() {
                    this.showLuggageDetails = false;
                    this.luggageData = null;
                    this.showAlert('Scan cancelled', 'info');
                },

                showAlert(message, type) {
                    const alertContainer = document.getElementById('alert-container');
                    const colors = {
                        success: 'bg-green-50 border-green-200 text-green-800',
                        error: 'bg-red-50 border-red-200 text-red-800',
                        info: 'bg-blue-50 border-blue-200 text-blue-800'
                    };
                    
                    const alertDiv = document.createElement('div');
                    alertDiv.className = `${colors[type]} border-2 rounded-lg p-4 text-center font-medium`;
                    alertDiv.textContent = message;
                    
                    alertContainer.innerHTML = '';
                    alertContainer.appendChild(alertDiv);
                    
                    // Auto-remove after 5 seconds
                    setTimeout(() => {
                        if (alertDiv.parentNode) {
                            alertDiv.parentNode.removeChild(alertDiv);
                        }
                    }, 5000);
                }
            }
        }

        // Cleanup on page unload
        window.addEventListener('beforeunload', function() {
            // Stop scanner if running
            if (window.html5QrcodeScanner) {
                window.html5QrcodeScanner.stop();
            }
        });
    </script>
</body>
</html>