@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="bg-gray-50">
    <section class="gradient-bg text-white pt-24 pb-16 rounded-b-3xl shadow-lg">
        <div class="mx-auto px-4 max-w-4xl"> <!-- Diubah dari "container" ke "mx-auto max-w-4xl" -->
            <div class="flex flex-col lg:flex-row items-center">
                <div class="lg:w-1/2 mb-12 lg:mb-0 fade-in">
                <h1 class="text-5xl font-bold mb-6 leading-tight text-inner-shadow">
                Temukan Potensi Diri dengan 
                <span class="text-neura-yellow">NEURA</span>
                </h1>
                <p class="text-lg lg:text-xl mb-8 leading-relaxed text-white text-shadow-md text-inner-shadow">
                    Platform asesmen digital yang mengidentifikasi gaya belajar, minat bakat, dan dominasi otak Anda melalui pendekatan  yang interaktif dan berkelanjutan.
                </p>

                    <div class="flex space-x-4">
                        <a href="/register" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-gray-600 hover:text-white transition">
                            Mulai Asesmen
                        </a>
                        <a href="#tentang" class="bg-yellow-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-gray-600 hover:text-white transition">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>

                <div class="lg:w-1/2 flex justify-center fade-in">
                    <img src="{{ asset('images/neura1.png') }}" alt="Ilustrasi NEURA" class="w-full max-w-md lg:max-w-lg rounded-2xl">
                </div>
            </div>
        </div>
    </section>
</div>


    <!-- About Section -->
    <section id="tentang" class="py-16 bg-white rounded-xl mx-4 mt-8 shadow-md">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Mengapa NEURA?</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Sistem pendidikan yang seragam tidak selalu sesuai dengan keberagaman karakteristik belajar setiap individu
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Masalah -->
                <div class="fade-in bg-red-50 p-6 rounded-2xl shadow">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Permasalahan yang Kami Atasi</h3>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="bg-red-100 text-red-600 rounded-full p-2 mt-1">❌</div>
                            <p class="text-gray-700">Pendekatan pengajaran yang bersifat seragam dan tidak adaptif</p>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="bg-red-100 text-red-600 rounded-full p-2 mt-1">❌</div>
                            <p class="text-gray-700">Asesmen psikologis konvensional yang tidak berkelanjutan</p>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="bg-red-100 text-red-600 rounded-full p-2 mt-1">❌</div>
                            <p class="text-gray-700">Layanan asesmen profesional dengan biaya tinggi dan akses terbatas</p>
                        </div>
                    </div>
                </div>

                <!-- Solusi -->
                <div class="fade-in bg-green-50 p-6 rounded-2xl shadow">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Solusi NEURA</h3>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="bg-green-100 text-green-600 rounded-full p-2 mt-1">✅</div>
                            <p class="text-gray-700">Platform digital yang fleksibel dan dapat diakses secara luas</p>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="bg-green-100 text-green-600 rounded-full p-2 mt-1">✅</div>
                            <p class="text-gray-700">Asesmen yang interaktif dan tidak membosankan</p>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="bg-green-100 text-green-600 rounded-full p-2 mt-1">✅</div>
                            <p class="text-gray-700">Pemantauan berkala dan berkesinambungan setiap bulan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="gradient-bg text-white py-16 mt-16 rounded-t-3xl shadow-inner">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold mb-6 leading-tight text-inner-shadow">Mulai Perjalanan Penemuan Diri Anda</h2>
            <p class="text-lg lg:text-xl mb-8 leading-relaxed text-white text-shadow-md text-inner-shadow">
                Bergabunglah dengan ribuan pengguna yang telah menemukan potensi terbaik mereka
            </p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="/register" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-gray-600 hover:text-white transition">
                    Daftar Sekarang - Gratis
                </a>
                <a href="/login" class="bg-yellow-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-gray-600 hover:text-white transition">
                    Sudah Punya Akun? Masuk
                </a>
            </div>
        </div>
    </section>
</div>
@endsection

    <style>
        .gradient-bg {
        background: linear-gradient(to bottom, #3b82f6, #a5f3fc);
    }

    .text-inner-shadow {
    text-shadow: 1px 1px 4px rgba(0, 0, 0, 1);
    }

    .text-shadow-md {
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 1);
    }

    .fade-in {
        animation: fadeIn 1s ease-in;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    </style>

    @section('scripts')
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in');
                }
            });
        }, observerOptions);

        document.querySelectorAll('section > div').forEach(el => {
            observer.observe(el);
        });
    </script>
    @endsection
</div>
