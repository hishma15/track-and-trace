<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Track & Trace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Lustria&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

        <!--Icons from fontawsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body class="min-h-screen" style="background-image: url('/images/backgroundimg.jpeg'); background-size: cover; background-position: center;">    

<!-- Logo -->
    <div class="mt-4 flex items-start justify-between px-6">
        <!-- Left: Logo -->
        <div class="text-2xl font-bold flex items-center gap-2">
            <img src="{{ asset('images/tntlogo.png') }}" alt="Logo" class="w-20 h-20">
            <span style="color: #55372c; font-family: 'Anton', sans-serif;">Track N’ <br> Trace</span>
        </div>

        <!-- Center: Page Header -->
        <div class="flex-1 text-center -ml-20 mt-4">
            <h1 class="text-4xl font-bold text-[#55372c]">About Us</h1>
        </div>
    </div>

    <div class="flex-1 p-5">

            <!-- Welcome Section -->
            <div class="bg-[#55372c] rounded-xl p-8 mb-8 text-[#edede1] shadow-xl">
                <h2 class="text-3xl font-bold mb-4 text-center">Welcome to Track N' Trace.</h2>
                <p class="text-center text-[#edede1] text-lg">QR Based Lost Luggage management system</p>
            </div>

            <!-- Team Description -->
            <div class="bg-[#edede1] backdrop-blur-sm rounded-xl p-8 mb-8 shadow-lg border border-[#edede1]/70">
                <p class="text-lg text-[#55372c] leading-relaxed text-center">
                    We are a team of student innovators from Group 14, dedicated to creating practical, 
                    user-friendly tech solutions that solve real-world problems. Track & Trace is our 
                    answer to the long-standing issue of lost luggage within Sri Lanka's railway system.
                </p>
            </div>

            <!-- The Problem Section -->
            <div class="bg-[#edede1] backdrop-blur-sm rounded-xl p-8 mb-8 shadow-lg border border-[#edede1]/70">
                <h3 class="text-2xl font-bold text-[#55372c] mb-6">The Problem</h3>
                
                <p class="text-lg text-[#55372c]  mb-6 leading-relaxed">
                    Lost luggage is a common, frustrating experience for railway travelers. Passengers 
                    often face:
                </p>

                <div class="space-y-3 mb-6">
                    <ul class="list-disc list-inside space-y-2 text-[#55372c]">
                        <li>No standardized reporting system</li>
                        <li>Manual logbooks and unclear processes</li>
                        <li>Delayed or lost claims</li>
                        <li>No way to prove ownership or track progress</li>
                        <li>Overburdened railway staff with no digital tools</li>
                    </ul>

                <p class="text-lg text-[#55372c] leading-relaxed">
                    The result? Confusion, miscommunication, and zero accountability. We saw this gap 
                    and decided: there must be a better way.
                </p>
            </div>

        </div>

        <!-- Our solution -->
            <div class="bg-[#edede1] backdrop-blur-sm rounded-xl p-8 mb-8 shadow-lg border border-[#edede1]/70">
                <h3 class="text-2xl font-bold text-[#55372c] mb-6">Our Solution</h3>
                
                <p class="text-lg text-[#55372c]  mb-6 leading-relaxed">
                    Track &amp; Trace is a QR-based digital lost luggage management platform designed specifically for Sri Lankan Railways. 
                </p>
                <p class="text-lg text-[#55372c]  mb-6 leading-relaxed">
                    It lets travelers, staff and admin report, track and recover luggage quickly, securely and reliably - with full transparency.
                </p>

                
            </div>

    </div>


 

</body>
</html>