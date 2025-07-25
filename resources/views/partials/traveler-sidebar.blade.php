@php
    $active = $active ?? '';
@endphp

<aside class="w-72 shadow-lg" style="background-color: #dec9ae;">
    <div class="p-6">
        {{-- Logo --}}
        <div class="text-2xl font-bold flex items-center gap-2 mb-10">
            <img src="{{ asset('images/tntlogo.png') }}" alt="Logo" class="w-20 h-20">
            <span style="color: #55372c; font-family: 'Anton', sans-serif;">Track N’ <br> Trace</span>
        </div>

        {{-- Navigation --}}
        <nav class="space-y-2">
            <a href="{{ route('traveler.travelerDashboard') }}"
               class="nav-item flex items-center gap-3 p-3 rounded-lg text-gray-700 font-medium {{ $active === 'dashboard' ? 'active' : '' }}">
                <i class="fas fa-home w-5 h-5"></i>
                Dashboard
            </a>

            <a href="{{ route('luggage.index') }}"
               class="nav-item flex items-center gap-3 p-3 rounded-lg text-gray-700 font-medium {{ $active === 'my-luggages' ? 'active' : '' }}">
                <i class="fas fa-suitcase-rolling w-5 h-5"></i>
                My Luggages
            </a>

            <a href="#"
               class="nav-item flex items-center gap-3 p-3 rounded-lg text-gray-700 font-medium {{ $active === 'lost-luggage' ? 'active' : '' }}">
                <i class="fas fa-search w-5 h-5"></i>
                Lost Luggage
            </a>

            <a href="#"
               class="nav-item flex items-center gap-3 p-3 rounded-lg text-gray-700 font-medium {{ $active === 'found-luggage' ? 'active' : '' }}">
                <i class="fas fa-box-open w-5 h-5"></i>
                Found Luggage
            </a>

            <a href="#"
               class="nav-item flex items-center gap-3 p-3 rounded-lg text-gray-700 font-medium {{ $active === 'reports' ? 'active' : '' }}">
                <i class="fas fa-file-alt w-5 h-5"></i>
                Total Reports
            </a>

            <a href="{{ route('traveler.profile.show') }}"
               class="nav-item flex items-center gap-3 p-3 rounded-lg text-gray-700 font-medium {{ $active === 'profile' ? 'active' : '' }}">
                <i class="fas fa-user w-5 h-5"></i>
                My Profile
            </a>

            <a href="#"
               class="nav-item flex items-center gap-3 p-3 rounded-lg text-gray-700 font-medium {{ $active === 'notifications' ? 'active' : '' }}">
                <i class="fas fa-bell w-5 h-5"></i>
                Notifications
            </a>

            <a href="#"
               class="nav-item flex items-center gap-3 p-3 rounded-lg text-gray-700 font-medium {{ $active === 'about' ? 'active' : '' }}">
                <i class="fas fa-info-circle w-5 h-5"></i>
                About Us
            </a>

            <a href="#"
               class="nav-item flex items-center gap-3 p-3 rounded-lg text-gray-700 font-medium {{ $active === 'help' ? 'active' : '' }}">
                <i class="fas fa-question-circle w-5 h-5"></i>
                Help & Support
            </a>

            {{-- Logout --}}
            <form method="POST" action="{{ route('traveler.logout') }}" class="mt-10">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-3 p-3 rounded-lg text-red-600 font-medium nav-item hover:bg-red-100 transition">
                    <i class="fas fa-sign-out-alt w-5 h-5"></i>
                    Logout
                </button>
            </form>
        </nav>
    </div>
</aside>
