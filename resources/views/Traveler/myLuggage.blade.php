<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>My Luggages - Track & Trace</title>
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
        .nav-item.active {
            background: rgba(139, 69, 19, 0.15);
            border-right: 3px solid #8B4513;
        }
        .luggage-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .welcome-card {
            background: linear-gradient(135deg, #8B4513 0%, #654321 100%);
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
        .search-box {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }
        .profile-avatar {
            background: linear-gradient(135deg, #87CEEB 0%, #4682B4 100%);
        }

        /* QR Code Modal Styles - Updated to match update modal */
        .qr-modal {
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
        }
        
        .qr-content {
            background-image: url('/images/backgroundimg.jpeg');
            background-size: cover;
            background-position: center;
            border-radius: 12px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            max-height: 90vh;
            overflow-y: auto;
        }

        .qr-image-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
        }

        .download-btn {
            background: linear-gradient(135deg, #228B22 0%, #32CD32 100%);
            transition: all 0.3s ease;
            /* background-color: #55372c; 
            color: #edede1; */
        }

        .download-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(34, 139, 34, 0.3);
        }

        .loading-spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #8B4513;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>

<body style="background-image: url('/images/backgroundimg.jpeg'); background-size: cover;">
    <div x-data="{ 
        qrModalOpen: false, 
        currentLuggageId: null, 
        qrImageUrl: '', 
        generatingLuggageIds: [] 
    }" class="flex min-h-screen">
        
        {{-- Sidebar --}}
        @include('partials.traveler-sidebar', ['active' => 'my-luggages'])

        {{-- Main --}}
        <main class="flex-1 overflow-hidden">
            <!-- Header -->
            <header class="bg-white/80 backdrop-blur-sm border-b border-gray-200 px-8 py-4">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-semibold text-[#55372c]">My Luggages</h1>
                </div>
            </header>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-6 text-center">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Action Buttons --}}
            <div class="m-5 flex flex-col md:flex-row justify-center gap-6">

                {{-- Register Luggage Popup Trigger --}}
                @include('partials.register-luggage-popup')

                <!-- Report Lost Luggage -->
                <div class="action-card rounded-2xl p-6 cursor-pointer bg-white/80 transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-20 h-20 bg-teal-100 rounded-xl flex items-center justify-center">
                            <img src="{{ asset('images/report.png') }}" alt="Report" class="w-12 h-17">
                        </div>
                        <div>
                        <h3 class="text-xl font-semibold text-gray-800">Report Lost Luggage</h3>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Luggage Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 m-5 p-5 gap-8">
                @forelse ($luggages as $luggage)
                    <div class="bg-white/90 rounded-2xl overflow-hidden shadow-md luggage-card transition transform hover:scale-[1.01] relative flex flex-col justify-between">

                        {{-- Image --}}
                        <img src="{{ $luggage->image_path ? asset('storage/' . $luggage->image_path) : asset('images/noimage.png') }}"
                            class="w-full h-48 object-contain bg-white rounded-t-2xl" alt="Luggage Image">

                        {{-- Details & Buttons --}}
                        <div class="flex flex-col justify-between flex-grow">
                            <div class="p-5 space-y-2">
                                <p><strong>Color:</strong> {{ $luggage->color ?? 'None' }}</p>
                                <p><strong>Brand / Type:</strong> {{ $luggage->brand_type ?? 'None' }}</p>
                                <p><strong>Description:</strong> {{ $luggage->description ?? 'None' }}</p>
                                <p><strong>Features:</strong> {{ $luggage->unique_features ?? 'None' }}</p>
                            </div>

                            {{-- Buttons --}}
                            <div class="mt-auto px-5 pb-5 flex flex-wrap gap-3 justify-between items-center">
                                <!-- Update Button -->
                                <button @click="$dispatch('open-update-{{ $luggage->id }}')"
                                    class="bg-[#55372c] text-[#edede1] px-6 py-3 rounded-lg font-medium transition-all duration-200 hover:opacity-90 focus:outline-none focus:ring-4 focus:ring-gray-300">
                                    Update
                                </button>

                                <!-- Generate QR Button -->
                                <button @click="generateQrCode({{ $luggage->id }})"
                                    :disabled="generatingLuggageIds.includes({{ $luggage->id }})"
                                    class="bg-[#55372c] text-[#edede1] px-6 py-3 rounded-lg font-medium transition-all duration-200 hover:opacity-90 focus:outline-none focus:ring-4 focus:ring-gray-300 disabled:opacity-50">
                                    <span x-show="!generatingLuggageIds.includes({{ $luggage->id }})">Generate QR</span>
                                    <span x-show="generatingLuggageIds.includes({{ $luggage->id }})" class="flex items-center gap-2">
                                        <div class="loading-spinner w-4 h-4"></div>
                                        Generating...
                                    </span>
                                </button>

                                <form action="{{ route('luggage.destroy', $luggage->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this luggage?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash-alt text-xl"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center bg-white/90 text-gray-600 rounded-2xl p-10 shadow-md">
                        <p class="text-lg font-medium">You haven't registered any luggages yet.</p>
                    </div>
                @endforelse
            </div>

            <!-- Update Modals -->
            @foreach ($luggages as $luggage)
            <div 
            x-data="{ isOpen: false }" 
            x-on:open-update-{{ $luggage->id }}.window="isOpen = true"
            x-cloak
            >
                <div 
                    x-show="isOpen"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/70"
                >
                    <!-- Modal Box -->
                    <div 
                        @click.away="isOpen = false"
                        class="p-6 rounded-xl shadow-xl w-full max-w-2xl mx-auto relative max-h-[90vh] overflow-y-auto"
                        style="background-image: url('/images/backgroundimg.jpeg'); background-size: cover; background-position: center;"
                    >
                        <!-- Close Button -->
                        <button 
                            @click="isOpen = false"
                            class="absolute top-2 right-4 text-gray-500 text-2xl hover:text-gray-700 cursor-pointer"
                        >&times;</button>

                        <h2 class="text-2xl mb-4 font-semibold text-[#55372c]">Update Luggage</h2>

                        <div class="rounded-t-xl p-6 flex justify-between items-center mb-4" style="background-color: #55372c; color: #edede1;">
                            <div>
                                <h2 class="text-xl font-bold">Luggage Update</h2>
                                <p class="text-sm">Modify your luggage details to keep information up to date.</p>
                            </div>
                        </div>

                        <!-- Update Form -->
                        <form action="{{ route('luggage.update', $luggage->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-[#edede1]/60 p-6 rounded-lg">
                            @csrf
                            @method('PUT')

                            <!-- Two Column Layout -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Left Column -->
                                <div class="space-y-4">
                                    <div>
                                        <label class="block font-medium">Brand / Type</label>
                                        <input type="text" name="brand_type" value="{{ $luggage->brand_type }}" required class="w-full border rounded px-3 py-2" />
                                    </div>

                                    <div>
                                        <label class="block font-medium">Color</label>
                                        <input type="text" name="color" value="{{ $luggage->color }}" required class="w-full border rounded px-3 py-2" />
                                    </div>

                                    <div>
                                        <label class="block font-medium">Upload New Image</label>
                                        <input type="file" name="image_path" class="w-full border rounded px-3 py-2 bg-white" />
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="space-y-4">
                                    <div>
                                        <label class="block font-medium">Current Image</label>
                                        @if ($luggage->image_path)
                                            <img src="{{ asset('storage/' . $luggage->image_path) }}" class="max-w-full h-auto rounded-lg shadow-md border" alt="Luggage Image" />
                                        @else
                                            <p class="text-gray-500">No image available.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Below Two Columns -->
                            <div class="space-y-4">
                                <div>
                                    <label class="block font-medium">Description</label>
                                    <textarea name="description" rows="3" class="w-full border rounded px-3 py-2">{{ $luggage->description }}</textarea>
                                </div>

                                <div>
                                    <label class="block font-medium">Unique Features</label>
                                    <textarea name="unique_features" rows="3" class="w-full border rounded px-3 py-2">{{ $luggage->unique_features }}</textarea>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end pt-4">
                                <button type="submit" class="w-full mt-4 py-3 text-white rounded-full" style="background-color: #55372c;">
                                    Update Luggage
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </main>

        <!-- QR Code Modal - Now outside of cards, similar to update modal -->
        <div x-show="qrModalOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 flex items-center justify-center qr-modal"
             @click.away="qrModalOpen = false">
            
            <div class="qr-content p-6 mx-4 max-w-2xl w-full relative">
                <!-- Close Button -->
                <button @click="qrModalOpen = false" 
                        class="absolute top-2 right-4 text-gray-500 text-2xl hover:text-gray-700 cursor-pointer z-10">
                    &times;
                </button>

                <!-- Header Section -->
                
                <div style="color: #55372c;">
                    <h2 class="text-2xl font-normal mb-6" style="color: #55372c;">QR Code Generator</h2>
                    
                </div>
                

                <!-- QR Code Container -->
                <div class="bg-[#edede1]/80 p-6 rounded-lg">

                
                    <div class="rounded-t-xl p-6 flex justify-between items-center mb-4" style="background-color: #55372c; color: #edede1;">
                        <div>
                            <h2 class="text-xl font-bold">Download your QR Code from  here.</h2>
                            <p class="text-sm">Please note that it is the traveler's responsibility to print and securely attach the QR code to their luggage prior to travel.</p>
                        </div>
                    </div>

                    <!-- QR Code Display -->
                    <div class="qr-image-container mb-6 text-center">
                        <div class="flex justify-center">
                            <div :id="'qr-container-' + currentLuggageId" x-html="qrImageUrl" class="inline-block"></div>
                        </div>

                        <!-- Download Button -->
                        <button 
                            @click="downloadPNG(currentLuggageId)"
                            class="mt-6 download-btn px-8 py-3 text-white font-semibold rounded-full text-lg"
                        >
                            Download QR
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('partials.footer')

    <!-- Canvas for SVG to PNG conversion -->
    <canvas id="qr-canvas" style="display: none;"></canvas>

    <script>
        // CSRF Token setup for AJAX requests
document.addEventListener('DOMContentLoaded', function() {
    // Set up CSRF token for all AJAX requests
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Helper function to wait for SVG to render in DOM
    function waitForSvgRender(luggageId, callback, maxAttempts = 20) {
        let attempts = 0;
        
        function checkSvg() {
            attempts++;
            const container = document.getElementById(`qr-container-${luggageId}`);
            const svg = container?.querySelector('svg');
            
            if (svg) {
                console.log('SVG confirmed in DOM after', attempts, 'attempts');
                callback();
            } else if (attempts < maxAttempts) {
                console.log('Waiting for SVG render, attempt:', attempts);
                setTimeout(checkSvg, 50); // Check every 50ms
            } else {
                console.warn('SVG not rendered after maximum attempts');
                callback(); // Still show modal even if SVG not detected
            }
        }
        
        // Start checking immediately
        checkSvg();
    }
    
    // Make generateQrCode function globally available
    window.generateQrCode = function(luggageId) {
        console.log('Generating QR for luggage ID:', luggageId);
        
        // Get the main Alpine component
        const mainComponent = Alpine.$data(document.querySelector('[x-data*="qrModalOpen"]'));
        
        // Add this luggage ID to the generating list
        mainComponent.generatingLuggageIds.push(luggageId);
        mainComponent.currentLuggageId = luggageId;

        fetch(`/luggage/${luggageId}/generate-qr`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
            },
        })
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                mainComponent.qrImageUrl = data.qr_svg;
                
                // Wait for Alpine.js to render the SVG before opening modal
                waitForSvgRender(luggageId, () => {
                    mainComponent.qrModalOpen = true;
                    console.log('QR SVG loaded successfully for luggage:', luggageId);
                });
            } else {
                alert('Failed to generate QR code: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while generating QR code: ' + error.message);
        })
        .finally(() => {
            // Remove this luggage ID from the generating list
            const index = mainComponent.generatingLuggageIds.indexOf(luggageId);
            if (index > -1) {
                mainComponent.generatingLuggageIds.splice(index, 1);
            }
        });
    };
    
    // Make downloadPNG function globally available
    window.downloadPNG = function(luggageId) {
        console.log('Attempting to download PNG for luggage ID:', luggageId);
        
        const container = document.getElementById(`qr-container-${luggageId}`);
        if (!container) {
            console.error('QR container not found for ID:', luggageId);
            alert('QR container not found.');
            return;
        }
        
        const svg = container.querySelector('svg');
        if (!svg) {
            console.error('SVG not found in container for ID:', luggageId);
            
            // Get the main Alpine component and close the modal
            const mainComponent = Alpine.$data(document.querySelector('[x-data*="qrModalOpen"]'));
            mainComponent.qrModalOpen = false;
            
            // Show alert and suggest trying again
            alert('QR code is not ready yet. Please click "Generate QR" again to retry.');
            return;
        }

        performPngDownload(luggageId, svg);
    };

    // Separate function to perform the actual PNG download
    function performPngDownload(luggageId, svg) {
        console.log('SVG found, starting conversion...');

        try {
            // Get SVG dimensions or set default
            const svgWidth = svg.getAttribute('width') || svg.viewBox?.baseVal.width || 300;
            const svgHeight = svg.getAttribute('height') || svg.viewBox?.baseVal.height || 300;
            
            // Create a new SVG with explicit dimensions and white background
            const svgClone = svg.cloneNode(true);
            svgClone.setAttribute('width', svgWidth);
            svgClone.setAttribute('height', svgHeight);
            
            // Add white background rectangle if it doesn't exist
            const hasBackground = svgClone.querySelector('rect[fill="white"], rect[fill="#ffffff"]');
            if (!hasBackground) {
                const bgRect = document.createElementNS('http://www.w3.org/2000/svg', 'rect');
                bgRect.setAttribute('width', '100%');
                bgRect.setAttribute('height', '100%');
                bgRect.setAttribute('fill', 'white');
                svgClone.insertBefore(bgRect, svgClone.firstChild);
            }

            const svgData = new XMLSerializer().serializeToString(svgClone);
            const svgBlob = new Blob([svgData], { type: 'image/svg+xml;charset=utf-8' });
            const url = URL.createObjectURL(svgBlob);

            const img = new Image();
            img.onload = function() {
                console.log('Image loaded, creating canvas...');
                
                const canvas = document.getElementById('qr-canvas');
                if (!canvas) {
                    console.error('Canvas element not found');
                    alert('Canvas element not found');
                    URL.revokeObjectURL(url);
                    return;
                }
                
                // Set canvas size (make it larger for better quality)
                const scale = 2; // 2x scale for better quality
                canvas.width = parseInt(svgWidth) * scale;
                canvas.height = parseInt(svgHeight) * scale;

                const ctx = canvas.getContext('2d');
                
                // Fill with white background first
                ctx.fillStyle = 'white';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                
                // Scale the context for better quality
                ctx.scale(scale, scale);
                
                // Draw the SVG image
                ctx.drawImage(img, 0, 0, parseInt(svgWidth), parseInt(svgHeight));

                // Convert to PNG and download
                canvas.toBlob(function(blob) {
                    const pngUrl = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = pngUrl;
                    a.download = `luggage-qr-${luggageId}.png`;
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    
                    // Clean up URLs
                    URL.revokeObjectURL(pngUrl);
                    URL.revokeObjectURL(url);
                    
                    console.log('PNG download completed successfully');
                }, 'image/png', 1.0);
            };
            
            img.onerror = function() {
                console.error('Failed to load SVG as image');
                alert('Failed to convert SVG to image');
                URL.revokeObjectURL(url);
            };
            
            img.src = url;
            
        } catch (error) {
            console.error('Error during PNG conversion:', error);
            alert('Error occurred during PNG conversion: ' + error.message);
        }
    }
});

// Success message auto-hide
setTimeout(() => {
    const alert = document.querySelector('.bg-green-100');
    if (alert) {
        alert.style.transition = 'opacity 0.5s ease';
        alert.style.opacity = '0';

        setTimeout(() => {
            alert.remove();
        }, 500);
    }
}, 2000);
    </script>
</body>
</html>