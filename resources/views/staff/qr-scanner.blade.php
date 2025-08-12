<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>QR Code Scanner - Track N' Trace</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Lustria&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <!-- QR Scanner Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><linearGradient id="bg" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:%23f5f1eb;stop-opacity:1" /><stop offset="100%" style="stop-color:%23e8ddd1;stop-opacity:1" /></linearGradient></defs><rect width="1000" height="1000" fill="url(%23bg)"/></svg>');
            background-size: cover;
            background-attachment: fixed;
            margin: 0;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .header h1 {
            color: #55372c;
            margin: 0;
            font-size: 2rem;
            font-weight: 600;
        }

        .scanner-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .scanner-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .scanner-card h2 {
            color: #55372c;
            margin-bottom: 20px;
            font-size: 1.5rem;
            text-align: center;
        }

        #qr-reader {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            min-height: 300px;
            background: #f0f0f0;
        }

        #qr-reader video {
            width: 100% !important;
            height: auto !important;
            border-radius: 15px;
        }

        #qr-reader canvas {
            display: none !important;
        }

        .scan-controls {
            text-align: center;
            margin-top: 20px;
        }

        .scan-btn {
            background: linear-gradient(135deg, #55372c 0%, #7a4f3f 100%);
            color: #edede1;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 5px;
        }

        .scan-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(85, 55, 44, 0.3);
        }

        .scan-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .luggage-details {
            display: none;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            margin-top: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .luggage-details.show {
            display: block;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .details-header {
            background: linear-gradient(135deg, #55372c 0%, #7a4f3f 100%);
            color: #edede1;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 25px;
            text-align: center;
        }

        .details-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .luggage-image {
            text-align: center;
        }

        .luggage-image img {
            max-width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .luggage-info {
            display: grid;
            gap: 15px;
        }

        .info-item {
            background: rgba(245, 241, 235, 0.7);
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid #55372c;
        }

        .info-label {
            font-weight: 600;
            color: #55372c;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .info-value {
            color: #333;
            font-size: 1rem;
        }

        .traveler-details {
            background: rgba(135, 206, 235, 0.1);
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 25px;
        }

        .traveler-header {
            color: #55372c;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 15px;
            text-align: center;
        }

        .traveler-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .status-section {
            text-align: center;
        }

        .current-status {
            display: inline-block;
            padding: 10px 25px;
            border-radius: 25px;
            font-weight: 600;
            margin-bottom: 20px;
            font-size: 1.1rem;
        }

        .status-safe {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
        }

        .status-lost {
            background: linear-gradient(135deg, #f44336, #da190b);
            color: white;
        }

        .status-found {
            background: linear-gradient(135deg, #2196F3, #1976D2);
            color: white;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .mark-found-btn {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 25px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .mark-found-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.4);
        }

        .cancel-btn {
            background: linear-gradient(135deg, #757575, #616161);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 25px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .cancel-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(117, 117, 117, 0.4);
        }

        .alert {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 500;
        }

        .alert-success {
            background: rgba(76, 175, 80, 0.1);
            color: #2e7d32;
            border: 2px solid rgba(76, 175, 80, 0.3);
        }

        .alert-error {
            background: rgba(244, 67, 54, 0.1);
            color: #c62828;
            border: 2px solid rgba(244, 67, 54, 0.3);
        }

        .alert-info {
            background: rgba(33, 150, 243, 0.1);
            color: #1565c0;
            border: 2px solid rgba(33, 150, 243, 0.3);
        }

        .loading {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 20px;
            color: #55372c;
        }

        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #55372c;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .camera-permissions {
            text-align: center;
            padding: 20px;
            background: rgba(255, 235, 59, 0.1);
            border-radius: 10px;
            margin: 10px 0;
            border: 2px solid rgba(255, 235, 59, 0.3);
            color: #f57f17;
        }

        @media (max-width: 768px) {
            .scanner-section {
                grid-template-columns: 1fr;
            }
            
            .details-grid {
                grid-template-columns: 1fr;
            }
            
            .traveler-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-qrcode"></i> QR Code Scanner - Track N' Trace</h1>
        </div>

        <div id="alert-container"></div>

        <div class="scanner-section">
            <div class="scanner-card">
                <h2><i class="fas fa-camera"></i> Scan QR Code</h2>
                <div id="qr-reader"></div>
                <div class="scan-controls">
                    <button id="start-scan" class="scan-btn">
                        <i class="fas fa-play"></i> Start Scanner
                    </button>
                    <button id="stop-scan" class="scan-btn" disabled>
                        <i class="fas fa-stop"></i> Stop Scanner
                    </button>
                </div>
                <div id="camera-permissions" class="camera-permissions" style="display: none;">
                    <p><i class="fas fa-exclamation-triangle"></i> Please allow camera access to use the QR scanner</p>
                </div>
            </div>

            <div class="scanner-card">
      <h2><i class="fas fa-upload"></i> Upload QR Image</h2>
      <p style="text-align: center; color: #666; margin-bottom: 20px;">
        If display issues or glare prevent scanning, upload the QR code image directly.
      </p>
      <div style="text-align: center;">
        <input type="file" id="qr-file-upload" accept="image/*" style="padding: 10px; margin-bottom: 15px;">
      </div>

            <div class="scanner-card">
                <h2><i class="fas fa-keyboard"></i> Manual Entry</h2>
                <p style="text-align: center; color: #666; margin-bottom: 20px;">
                    If the QR code is damaged, you can enter the luggage ID manually
                </p>
                <div style="text-align: center;">
                    <input type="text" id="manual-luggage-id" placeholder="Enter Luggage ID" 
                           style="padding: 12px; border: 2px solid #ddd; border-radius: 25px; width: 200px; text-align: center; margin-bottom: 15px;">
                    <br>
                    <button id="manual-search" class="scan-btn">
                        <i class="fas fa-search"></i> Search Luggage
                    </button>
                </div>
            </div>
        </div>

        <div id="luggage-details" class="luggage-details">
            <div class="details-header">
                <h2><i class="fas fa-suitcase"></i> Luggage Found!</h2>
                <p>Please verify the details below and mark as found if correct</p>
            </div>

            <div class="details-grid">
                <div class="luggage-image">
                    <img id="luggage-img" src="https://via.placeholder.com/250x250?text=No+Image" alt="Luggage Image">
                </div>

                <div class="luggage-info">
                    <div class="info-item">
                        <div class="info-label">Luggage ID</div>
                        <div class="info-value" id="luggage-id-display">-</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Color</div>
                        <div class="info-value" id="luggage-color">-</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Brand/Type</div>
                        <div class="info-value" id="luggage-brand">-</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Description</div>
                        <div class="info-value" id="luggage-description">-</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Unique Features</div>
                        <div class="info-value" id="luggage-features">-</div>
                    </div>
                </div>
            </div>

            <div class="traveler-details">
                <div class="traveler-header">
                    <i class="fas fa-user"></i> Traveler Contact Information
                </div>
                <div class="traveler-grid">
                    <div class="info-item">
                        <div class="info-label">Full Name</div>
                        <div class="info-value" id="traveler-name">-</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Phone Number</div>
                        <div class="info-value" id="traveler-phone">-</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email Address</div>
                        <div class="info-value" id="traveler-email">-</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">National ID</div>
                        <div class="info-value" id="traveler-national-id">-</div>
                    </div>
                </div>
            </div>

            <div class="status-section">
                <div class="info-label" style="text-align: center; margin-bottom: 10px;">Current Status</div>
                <div id="current-status" class="current-status status-safe">Safe</div>
                
                <div class="action-buttons">
                    <button id="mark-found-btn" class="mark-found-btn">
                        <i class="fas fa-check"></i> Mark as Found
                    </button>
                    <button id="cancel-btn" class="cancel-btn">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let html5QrcodeScanner = null;
        let currentLuggageData = null;
        let isScanning = false;

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Page loaded, setting up...');
            setupEventListeners();
            
            // Check camera permissions on load
            checkCameraPermissions();
            
            // Check if we need to auto-load luggage (when staff scans QR code)
            const autoLoadLuggageId = '{{ $auto_load_luggage_id ?? "" }}';
            if (autoLoadLuggageId) {
                showAlert('QR Code detected! Loading luggage details...', 'info');
                fetchLuggageDetails(autoLoadLuggageId);
            }
        });

        function setupEventListeners() {
            document.getElementById('start-scan').addEventListener('click', startScanner);
            document.getElementById('stop-scan').addEventListener('click', stopScanner);
            document.getElementById('manual-search').addEventListener('click', manualSearch);
            document.getElementById('mark-found-btn').addEventListener('click', markAsFound);
            document.getElementById('cancel-btn').addEventListener('click', cancelScan);
            
            // Enter key for manual search
            document.getElementById('manual-luggage-id').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    manualSearch();
                }
            });
        }

        async function checkCameraPermissions() {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ video: true });
                stream.getTracks().forEach(track => track.stop());
                console.log('Camera permissions granted');
                document.getElementById('camera-permissions').style.display = 'none';
            } catch (err) {
                console.log('Camera permissions denied or not available:', err);
                document.getElementById('camera-permissions').style.display = 'block';
                showAlert('Camera access is required for QR scanning', 'error');
            }
        }

        async function startScanner() {
            console.log('Starting scanner...');
            
            if (isScanning) {
                console.log('Already scanning, stopping first...');
                await stopScanner();
            }

            try {
                html5QrcodeScanner = new Html5Qrcode("qr-reader");
                
                const config = {
                    fps: 10,
                    qrbox: { width: 250, height: 250 },
                    aspectRatio: 1.0,
                    disableFlip: false,
                    videoConstraints: {
                        facingMode: "environment"
                    }
                };

                console.log('Requesting camera access...');
                
                await html5QrcodeScanner.start(
                    { facingMode: "environment" },
                    config,
                    onScanSuccess,
                    onScanError
                );

                isScanning = true;
                updateScanButtons(true);
                showAlert('Scanner started successfully! Point camera at QR code', 'success');
                console.log('Scanner started successfully');
                
                // Hide camera permission message if shown
                document.getElementById('camera-permissions').style.display = 'none';

            } catch (err) {
                console.error('Scanner start error:', err);
                isScanning = false;
                updateScanButtons(false);
                
                let errorMessage = 'Error starting scanner: ';
                if (err.name === 'NotAllowedError' || err.name === 'PermissionDeniedError') {
                    errorMessage += 'Camera permission denied. Please allow camera access and try again.';
                    document.getElementById('camera-permissions').style.display = 'block';
                } else if (err.name === 'NotFoundError') {
                    errorMessage += 'No camera found. Please ensure your device has a camera.';
                } else if (err.name === 'NotSupportedError') {
                    errorMessage += 'Camera not supported in this browser.';
                } else {
                    errorMessage += err.message || 'Unknown error occurred.';
                }
                
                showAlert(errorMessage, 'error');
            }
        }

        async function stopScanner() {
            console.log('Stopping scanner...');
            
            if (html5QrcodeScanner && isScanning) {
                try {
                    await html5QrcodeScanner.stop();
                    html5QrcodeScanner.clear();
                    html5QrcodeScanner = null;
                    isScanning = false;
                    updateScanButtons(false);
                    showAlert('Scanner stopped', 'info');
                    console.log('Scanner stopped successfully');
                } catch (err) {
                    console.error('Scanner stop error:', err);
                    // Force stop even if there's an error
                    isScanning = false;
                    updateScanButtons(false);
                    showAlert('Scanner stopped (with warnings)', 'info');
                }
            } else {
                console.log('Scanner was not running');
                isScanning = false;
                updateScanButtons(false);
            }
        }

        function updateScanButtons(isScanning) {
            document.getElementById('start-scan').disabled = isScanning;
            document.getElementById('stop-scan').disabled = !isScanning;
        }

        function onScanSuccess(decodedText, decodedResult) {
            console.log('Raw QR Code scanned:', decodedText);
            
            // Extract luggage ID from URL or direct ID
            let luggageId = decodedText;
            
            // If it's a URL, extract the ID
            if (decodedText.includes('/')) {
                const urlParts = decodedText.split('/');
                luggageId = urlParts[urlParts.length - 1];
                console.log('Extracted luggage ID from URL:', luggageId);
            }
            
            console.log('Final luggage ID to search:', luggageId);
            
            if (luggageId && (!isNaN(luggageId) || luggageId.length > 0)) {
                stopScanner();
                fetchLuggageDetails(luggageId);
            } else {
                showAlert('Invalid QR code format. Expected luggage ID, got: ' + decodedText, 'error');
                console.error('Invalid QR format:', decodedText);
            }
        }

        function onScanError(error) {
            // Only log errors, don't show them as they're frequent while scanning
            // console.log('Scan error:', error);
        }

        function manualSearch() {
            const luggageId = document.getElementById('manual-luggage-id').value.trim();
            if (!luggageId) {
                showAlert('Please enter a luggage ID', 'error');
                return;
            }

            fetchLuggageDetails(luggageId);
        }

        // UPDATED: Real API call to match your routes
        function fetchLuggageDetails(luggageId) {
            showLoading('Fetching luggage details...');
            
            // Make actual API call to your Laravel backend using the correct route
            fetch(`/api/qr-scan/luggage/${luggageId}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error(err.message || `HTTP ${response.status}: ${response.statusText}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                hideLoading();
                console.log('API Response:', data);
                
                if (data.success) {
                    currentLuggageData = data;
                    displayLuggageDetails(data);
                } else {
                    showAlert('Error: ' + (data.message || 'Unknown error occurred'), 'error');
                }
            })
            .catch(error => {
                hideLoading();
                console.error('API Error:', error);
                showAlert('Error fetching luggage details: ' + error.message, 'error');
            });
        }

        // UPDATED: Display function with better error handling
        function displayLuggageDetails(data) {
            console.log('Displaying luggage details:', data);
            
            // Check if data structure is correct
            if (!data.luggage || !data.traveler) {
                console.error('Invalid data structure:', data);
                showAlert('Invalid data received from server', 'error');
                return;
            }
            
            const { luggage, traveler } = data;
            
            try {
                // Update luggage information
                document.getElementById('luggage-id-display').textContent = luggage.id || 'N/A';
                document.getElementById('luggage-color').textContent = luggage.color || 'N/A';
                document.getElementById('luggage-brand').textContent = luggage.brand_type || 'N/A';
                document.getElementById('luggage-description').textContent = luggage.description || 'No description provided';
                document.getElementById('luggage-features').textContent = luggage.unique_features || 'No unique features listed';
                
                // Update luggage image
                const imgElement = document.getElementById('luggage-img');
                if (luggage.image_path) {
                    imgElement.src = luggage.image_path;
                    imgElement.onerror = function() {
                        console.log('Image failed to load:', luggage.image_path);
                        this.src = 'https://via.placeholder.com/250x250?text=No+Image';
                    };
                } else {
                    imgElement.src = 'https://via.placeholder.com/250x250?text=No+Image';
                }
                
                // Update traveler information
                document.getElementById('traveler-name').textContent = `${traveler.first_name || ''} ${traveler.last_name || ''}`.trim() || 'N/A';
                document.getElementById('traveler-phone').textContent = traveler.phone_no || 'N/A';
                document.getElementById('traveler-email').textContent = traveler.email || 'N/A';
                document.getElementById('traveler-national-id').textContent = traveler.national_id || 'N/A';
                
                // Update status
                const statusElement = document.getElementById('current-status');
                const status = luggage.status || 'Unknown';
                statusElement.textContent = status;
                statusElement.className = 'current-status status-' + status.toLowerCase();
                
                // Show/hide mark as found button based on status
                const markFoundBtn = document.getElementById('mark-found-btn');
                if (status.toLowerCase() === 'found') {
                    markFoundBtn.style.display = 'none';
                } else {
                    markFoundBtn.style.display = 'inline-block';
                }
                
                // Show details section
                const detailsSection = document.getElementById('luggage-details');
                detailsSection.classList.add('show');
                console.log('Details section should now be visible');
                
                showAlert('Luggage details loaded successfully!', 'success');
                
            } catch (error) {
                console.error('Error displaying luggage details:', error);
                showAlert('Error displaying luggage details: ' + error.message, 'error');
            }
        }

        // UPDATED: Real API call for marking as found
        function markAsFound() {
            if (!currentLuggageData) {
                showAlert('No luggage data available', 'error');
                return;
            }

            const luggageId = currentLuggageData.luggage.id;
            
            // Get optional comment and location
            const comment = prompt('Add a comment (optional):') || '';
            const location = prompt('Current location (optional):') || '';
            
            showLoading('Marking luggage as found...');
            
            fetch(`/api/qr-scan/luggage/${luggageId}/found`, {
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
            })
            .then(response => {
                console.log('Mark found response status:', response.status);
                return response.json();
            })
            .then(data => {
                hideLoading();
                console.log('Mark found response:', data);
                
                if (data.success) {
                    // Update current data
                    currentLuggageData.luggage.status = 'Found';
                    
                    // Update display
                    const statusElement = document.getElementById('current-status');
                    statusElement.textContent = 'Found';
                    statusElement.className = 'current-status status-found';
                    
                    // Hide mark as found button
                    document.getElementById('mark-found-btn').style.display = 'none';
                    
                    showAlert('Luggage successfully marked as found! Owner will be notified.', 'success');
                } else {
                    showAlert('Error: ' + (data.message || 'Failed to mark as found'), 'error');
                }
            })
            .catch(error => {
                hideLoading();
                console.error('Mark found API Error:', error);
                showAlert('Error marking luggage as found: ' + error.message, 'error');
            });
        }

        function cancelScan() {
            document.getElementById('luggage-details').classList.remove('show');
            currentLuggageData = null;
            document.getElementById('manual-luggage-id').value = '';
            showAlert('Scan cancelled', 'info');
        }

        function showAlert(message, type) {
            const alertContainer = document.getElementById('alert-container');
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type}`;
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

        function showLoading(message) {
            const alertContainer = document.getElementById('alert-container');
            const loadingDiv = document.createElement('div');
            loadingDiv.className = 'loading';
            loadingDiv.innerHTML = `
                <div class="spinner"></div>
                <span>${message}</span>
            `;
            
            alertContainer.innerHTML = '';
            alertContainer.appendChild(loadingDiv);
        }

        function hideLoading() {
            document.getElementById('alert-container').innerHTML = '';
        }

        // Handle page visibility changes (helps with camera cleanup)
        document.addEventListener('visibilitychange', function() {
            if (document.hidden && isScanning) {
                stopScanner();
            }
        });

        // Cleanup on page unload
        window.addEventListener('beforeunload', function() {
            if (isScanning) {
                stopScanner();
            }
        });
        
    </script>
</body>
</html>