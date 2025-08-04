<div x-data="{ openSidebar: false }" class="flex h-screen">


    <!-- Sidebar -->
    <aside
    class="fixed top-0 left-0 z-40 h-full w-72 shadow-lg transform transition-transform duration-300 ease-in-out
           md:translate-x-0"
    :class="openSidebar ? 'translate-x-0' : '-translate-x-full'"
    style="background-color: #dec9ae;"
>

        <!-- Close button on right edge of sidebar -->
        <!-- <button
            @click="openSidebar = false"
            class="absolute top-4 right-0 -mr-6 p-2 bg-[#dec9ae] rounded-l shadow-md text-[#55372c]"
            aria-label="Close sidebar"
        >
            <i class="fas fa-chevron-left text-2xl"></i>
        </button> -->

            <!-- Toggle Button (mobile only) -->
<button
    @click="openSidebar = !openSidebar"
    class="absolute top-4 right-0 -mr-6 text-[#55372c] md:hidden p-2 bg-[#dec9ae] rounded shadow"
    aria-label="Toggle sidebar"
>
    <!-- Show right chevron when sidebar is closed -->
    <i
      class="fas fa-chevron-right text-2xl"
      x-show="!openSidebar"
      x-transition
      style="display: none;"
    ></i>

    <!-- Show left chevron when sidebar is open -->
    <i
      class="fas fa-chevron-left text-2xl"
      x-show="openSidebar"
      x-transition
      style="display: none;"
    ></i>
</button>

        <div class="p-6">
            {{-- Logo --}}
            <div class="text-2xl font-bold flex items-center gap-2 mb-5">
                <img src="{{ asset('images/tntlogo.png') }}" alt="Logo" class="w-20 h-20">
                <span style="color: #55372c; font-family: 'Anton', sans-serif;">Track N’ <br> Trace</span>
            </div>

            {{-- Navigation --}}
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                   class="nav-item flex items-center gap-3 p-3 rounded-lg text-gray-700 font-medium {{ $active === 'dashboard' ? 'active' : '' }}">
                    <i class="fas fa-home w-5 h-5"></i>
                    Dashboard
                </a>

                <a href="#" class="nav-item flex items-center gap-3 p-3 rounded-lg text-gray-700 font-medium">
                        <i class="fas fa-compass w-5 h-5"></i>
                        Discover
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


                <a href="#"
                   class="nav-item flex items-center gap-3 p-3 rounded-lg text-gray-700 font-medium {{ $active === 'notifications' ? 'active' : '' }}">
                    <i class="fas fa-bell w-5 h-5"></i>
                    Notifications
                </a>

                <!-- <a href="#"
                   class="nav-item flex items-center gap-3 p-3 rounded-lg text-gray-700 font-medium {{ $active === 'about' ? 'active' : '' }}">
                    <i class="fas fa-info-circle w-5 h-5"></i>
                    About Us
                </a> -->
                                
                <a href="#" class="nav-item flex items-center gap-3 p-3 rounded-lg text-gray-700 font-medium">
                    <i class="fas fa-cog w-5 h-5"></i>
                    Settings
                </a>

                <a href="#"
                   class="nav-item flex items-center gap-3 p-3 rounded-lg text-gray-700 font-medium {{ $active === 'help' ? 'active' : '' }}">
                    <i class="fas fa-question-circle w-5 h-5"></i>
                    Help & Support
                </a>

                {{-- Logout --}}
                <form method="POST" action="{{ route('admin.logout') }}">
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

    <!-- Main content placeholder -->
    <div class="flex-1 ml-0 md:ml-72 transition-all duration-300 ease-in-out w-full">
        @yield('content')
    </div>
</div>
