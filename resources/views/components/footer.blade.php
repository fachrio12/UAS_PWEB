<footer class="bg-gray-800 text-white py-8 mt-auto">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="mb-4 md:mb-0">
                <h2 class="text-xl font-bold">
                    <span class="text-yellow-300">NEURA</span>
                </h2>
                <p class="text-gray-400 mt-2">Platform asesmen dengan pendekatan gamifikasi</p>
            </div>
            
            <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-8">
                <div>
                    <h3 class="font-semibold mb-2">Navigasi</h3>
                    <ul class="space-y-1">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition">Beranda</a></li>
                        @auth
                            @if(Auth::user()->role_id == 1)
                                <li><a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-white transition">Dashboard</a></li>
                            @else
                                <li><a href="{{ route('user.assessments') }}" class="text-gray-400 hover:text-white transition">Asesmen</a></li>
                            @endif
                        @else
                            <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition">Login</a></li>
                        @endauth
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-semibold mb-2">Kontak</h3>
                    <ul class="space-y-1">
                        <li class="text-gray-400">Email: Neura@example.com</li>
                        <li class="text-gray-400">Telp: +62 123 4567 890</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="border-t border-gray-700 mt-6 pt-6 text-center text-gray-500">
            <p>&copy; {{ date('Y') }} NEURA. Hak Cipta Dilindungi.</p>
        </div>
    </div>
</footer>