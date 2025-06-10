@extends('layouts.app')

@section('title', 'Hasil Asesmen')

@section('content')
<div class="print-area hidden-print">
    <div class="print-header">
        <h1 style="margin: 0; font-size: 18px; font-weight: bold;">HASIL ASESMEN</h1>
        <p style="margin: 5px 0 0 0; font-size: 14px;">{{ $assessment->name }}</p>
    </div>
    
    <div class="print-info-grid">
        <div>
            <h3 style="margin: 0 0 10px 0; font-size: 14px; font-weight: bold;">Informasi Peserta</h3>
            <p style="margin: 2px 0;"><strong>Nama:</strong> {{ auth()->user()->name }}</p>
            <p style="margin: 2px 0;"><strong>Tanggal:</strong> {{ $session->taken_at->format('d M Y, H:i') }}</p>
        </div>
        <div>
            <h3 style="margin: 0 0 10px 0; font-size: 14px; font-weight: bold;">Detail Asesmen</h3>
            <p style="margin: 2px 0;"><strong>Total Pertanyaan:</strong> {{ $assessment->questions_count ?? $assessment->questions()->count() }}</p>
            <p style="margin: 2px 0;"><strong>Kategori:</strong> {{ $results->first()->result_category ?? 'Overall Score' }}</p>
        </div>
    </div>
    
    <div class="print-score">
        SKOR TOTAL: {{ $results->first()->score ?? 0 }}
    </div>
    
    @if($results->isNotEmpty())
        <div class="print-interpretation">
            <h3 style="margin: 0 0 10px 0; font-size: 14px; font-weight: bold;">Interpretasi Hasil</h3>
            <p style="margin: 0; text-align: justify;">{{ strip_tags($results->first()->interpretation) }}</p>
        </div>
    @endif
    
    <div class="print-footer">
        <p style="margin: 0;">Dokumen ini dicetak pada {{ now()->format('d M Y, H:i') }} WIB</p>
        <p style="margin: 5px 0 0 0;">Hasil asesmen ini bersifat pribadi dan rahasia</p>
    </div>
</div>

<div class="min-h-screen bg-gray-100 py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header Success -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-6 border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="bg-green-100 rounded-full p-3 mr-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Asesmen Berhasil Diselesaikan!</h1>
                        <p class="text-gray-600 mt-1">Terima kasih telah menyelesaikan asesmen {{ $assessment->name }}</p>
                    </div>
                </div>
            </div>

            <!-- Assessment Info -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-3">Informasi Asesmen</h2>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nama Asesmen:</span>
                                <span class="font-medium text-gray-800">{{ $assessment->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal Pengerjaan:</span>
                                <span class="font-medium text-gray-800">{{ $session->taken_at->format('d M Y, H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total Pertanyaan:</span>
                                <span class="font-medium text-gray-800">{{ $assessment->questions_count ?? $assessment->questions()->count() }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <div class="bg-blue-50 rounded-lg p-6">
                            <div class="text-3xl font-bold text-blue-600 mb-2">
                                {{ $results->first()->score ?? 0 }}
                            </div>
                            <div class="text-gray-600 text-sm">Skor Total</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Results Section -->
            @if($results->isNotEmpty())
                @foreach($results as $result)
                    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                        <div class="flex items-start mb-4">
                            <div class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full mr-4 mt-1">
                                {{ $result->result_category }}
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="text-lg font-semibold text-gray-800">Hasil Interpretasi</h3>
                                    <span class="text-2xl font-bold text-blue-600">{{ $result->score }}</span>
                                </div>
                                
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <p class="text-gray-700 leading-relaxed">
                                        {!! nl2br(e($result->interpretation)) !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                    <div class="text-center text-gray-500">
                        <p>Hasil interpretasi sedang diproses...</p>
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="bg-white shadow-md rounded-lg p-6 no-print">
                <div class="text-center space-y-4">
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <a href="{{ route('user.progress') }}" 
                           class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors duration-200 font-medium">
                            Lihat Progress Saya
                        </a>
                        
                        <a href="{{ route('user.assessments') }}" 
                           class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition-colors duration-200 font-medium">
                            Kembali ke Daftar Asesmen
                        </a>
                    </div>
                    
                    <div class="pt-4 border-t">
                        <p class="text-sm text-gray-600 mb-3">Bagikan hasil Anda:</p>
                        <div class="flex justify-center space-x-3">
                            <button onclick="shareResult()" 
                                    class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition-colors duration-200 text-sm">
                                📱 Bagikan
                            </button>
                            
                            <button onclick="printResult()" 
                                    class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600 transition-colors duration-200 text-sm">
                                🖨️ Cetak
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recommendations -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6 mt-6 no-print">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">💡 Rekomendasi Selanjutnya</h3>
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="bg-white rounded-lg p-4">
                        <h4 class="font-medium text-gray-800 mb-2">Tingkatkan Pemahaman</h4>
                        <p class="text-sm text-gray-600">Lakukan asesmen serupa untuk memperdalam pemahaman tentang diri Anda.</p>
                    </div>
                    <div class="bg-white rounded-lg p-4">
                        <h4 class="font-medium text-gray-800 mb-2">Konsultasi</h4>
                        <p class="text-sm text-gray-600">Diskusikan hasil ini dengan konselor atau mentor untuk panduan lebih lanjut.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Animation Modal -->
<div id="success-animation" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg p-8 text-center max-w-md mx-4">
        <div class="animate-bounce mb-4">
            <div class="bg-green-100 rounded-full p-4 inline-block">
                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>
        <h3 class="text-xl font-semibold text-gray-800 mb-2">Selamat!</h3>
        <p class="text-gray-600">Asesmen Anda telah berhasil diselesaikan dengan baik.</p>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Show success animation on page load
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            document.getElementById('success-animation').classList.remove('hidden');
            setTimeout(function() {
                document.getElementById('success-animation').classList.add('hidden');
            }, 3000);
        }, 500);
    });

    // Share result function
    function shareResult() {
        const shareData = {
            title: 'Hasil Asesmen {{ $assessment->name }}',
            text: 'Saya baru saja menyelesaikan asesmen {{ $assessment->name }} dengan skor {{ $results->first()->score ?? 0 }}!',
            url: window.location.href
        };

        if (navigator.share && navigator.canShare(shareData)) {
            navigator.share(shareData);
        } else {
            // Fallback untuk browser yang tidak mendukung Web Share API
            const text = `Saya baru saja menyelesaikan asesmen {{ $assessment->name }} dengan skor {{ $results->first()->score ?? 0 }}! ${window.location.href}`;
            
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text).then(function() {
                    alert('Link telah disalin ke clipboard!');
                });
            } else {
                prompt('Salin link berikut:', text);
            }
        }
    }

    // Print result function
    function printResult() {
    // Tampilkan area cetak
    const printArea = document.querySelector('.print-area');
    const mainContent = document.querySelector('.min-h-screen');

    printArea.style.display = 'block';
    const originalDisplay = mainContent.style.display;
    mainContent.style.display = 'none';

    // Beri jeda agar browser sempat render sebelum mencetak
    setTimeout(() => {
        window.print();

        // Kembalikan tampilan asli setelah mencetak
        setTimeout(() => {
            printArea.style.display = 'none';
            mainContent.style.display = originalDisplay;
        }, 500);
    }, 200); // jeda 200ms
}


    // Animate progress bars on page load
    document.addEventListener('DOMContentLoaded', function() {
        const progressBars = document.querySelectorAll('[style*="width:"]');
        progressBars.forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => {
                bar.style.width = width;
            }, 1000);
        });
    });

    // Smooth scroll to results
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const firstResult = document.querySelector('.bg-white.shadow-md.rounded-lg');
            if (firstResult) {
                firstResult.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }, 1500);
    });
</script>

<style>
.hidden-print {
    display: none !important;
}

@media print {
    body * {
        visibility: hidden;
    }

    .print-area,
    .print-area * {
        visibility: visible;
    }

    .print-area {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        background: white !important;
        padding: 20px;
        font-size: 12px;
        line-height: 1.4;
        display: block !important;
    }

    .no-print {
        display: none !important;
    }

    .print-header {
        text-align: center;
        border-bottom: 2px solid #333;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .print-score {
        text-align: center;
        font-size: 16px;
        font-weight: bold;
        background: #f5f5f5;
        padding: 10px;
        margin: 15px 0;
        border: 1px solid #ddd;
    }

    .print-interpretation {
        background: #f9f9f9;
        padding: 15px;
        border-left: 3px solid #333;
        margin: 15px 0;
    }

    .print-footer {
        margin-top: 30px;
        text-align: center;
        font-size: 10px;
        color: #666;
        border-top: 1px solid #ddd;
        padding-top: 10px;
    }

    .print-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin: 20px 0;
    }

    @page {
        margin: 1.5cm;
        size: A4;
    }
}
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .bg-white.shadow-md.rounded-lg {
        animation: fadeIn 0.6s ease-out forwards;
    }
    
    .bg-white.shadow-md.rounded-lg:nth-child(2) { animation-delay: 0.1s; }
    .bg-white.shadow-md.rounded-lg:nth-child(3) { animation-delay: 0.2s; }
    .bg-white.shadow-md.rounded-lg:nth-child(4) { animation-delay: 0.3s; }
</style>
@endsection