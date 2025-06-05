<nav class="bg-indigo-600 text-white shadow-md">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <div class="flex items-center space-x-4">
                <!-- Logo -->
                <a href="{{ route('admin.dashboard') }}" class="font-bold text-xl">
                    <span class="text-yellow-300">NEURA</span>
                </a>
            </div>
            
            <!-- Navigation Links -->
            <div class="hidden md:flex items-center space-x-6">
                @guest
                    <a href="{{ route('login') }}" class="text-white hover:text-yellow-200 transition">Login</a>
                    <a href="{{ route('register') }}" class="text-white hover:text-yellow-200 transition">register</a>
                @else
                    @if(Auth::user()->role_id == 1)
                        <!-- Admin Links -->
                        <a href="{{ route('admin.dashboard') }}" class="text-white hover:text-yellow-200 transition">Dashboard</a>
                        <a href="{{ route('admin.assessments') }}" class="text-white hover:text-yellow-200 transition">Kelola Asesmen</a>

                    @else
                        <!-- User Links -->
                        <a href="{{ route('user.assessments') }}" class="text-white hover:text-yellow-200 transition">Asesmen</a>
                        <a href="{{ route('user.progress') }}" class="text-white hover:text-yellow-200 transition">Perkembangan</a>
                        <a href="https://wa.me/628980479370?text=halo%20admin%20neura%20saya%20ingin%20berkonsultasi%20tentang%20%3A%20..." target="_blank" class="text-white hover:text-yellow-200 transition">Konsultasi</a>

                    @endif
                    
                    <a href="{{ route(Auth::user()->role_id == 1 ? 'admin.profile' : 'user.profile') }}" class="text-white hover:text-yellow-200 transition">Profil</a>
                    
                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-white hover:text-yellow-200 transition">
                            Logout
                        </button>
                    </form>
                @endguest
            </div>
            
            <!-- Mobile Menu Button -->
            <div class="md:hidden" x-data="{ open: false }">
                <button @click="open = !open" class="text-white focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
                
                <!-- Mobile Menu -->
                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                    @guest
                        <a href="{{ route('login') }}" class="block px-4 py-2 text-gray-800 hover:bg-indigo-500 hover:text-white">Login</a>
                    @else
                        @if(Auth::user()->role_id == 1)
                            <!-- Admin Links -->
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-800 hover:bg-indigo-500 hover:text-white">Dashboard</a>
                            <a href="{{ route('admin.assessments') }}" class="block px-4 py-2 text-gray-800 hover:bg-indigo-500 hover:text-white">Kelola Asesmen</a>
                        @else
                            <!-- User Links -->
                            <a href="{{ route('user.assessments') }}" class="block px-4 py-2 text-gray-800 hover:bg-indigo-500 hover:text-white">Asesmen</a>
                            <a href="{{ route('user.progress') }}" class="block px-4 py-2 text-gray-800 hover:bg-indigo-500 hover:text-white">Perkembangan</a>
                        @endif
                        
                        <a href="{{ route(Auth::user()->role_id == 1 ? 'admin.profile' : 'user.profile') }}" class="block px-4 py-2 text-gray-800 hover:bg-indigo-500 hover:text-white">Profil</a>
                        
                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-gray-800 hover:bg-indigo-500 hover:text-white">
                                Logout
                            </button>
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</nav>