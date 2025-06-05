@extends('layouts.app')

@section('title', 'Mengerjakan Asesmen')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">{{ $assessment->name }}</h2>
                        <p class="text-gray-600 mt-2">{{ $assessment->description }}</p>
                    </div>
                    <div class="text-right">
                        <div class="text-sm text-gray-500">Total Pertanyaan</div>
                        <div class="text-2xl font-bold text-blue-600">{{ $questions->count() }}</div>
                    </div>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="bg-white shadow-md rounded-lg p-4 mb-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700">Progress</span>
                    <span class="text-sm font-medium text-blue-600" id="progress-text">0 dari {{ $questions->count() }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 0%" id="progress-bar"></div>
                </div>
            </div>

            <!-- Assessment Form -->
            <form action="{{ route('user.assessments.submit', $assessment->id) }}" method="POST" id="assessment-form">
                @csrf
                
                @foreach($questions as $index => $question)
                    <div class="bg-white shadow-md rounded-lg p-6 mb-6 question-card" data-question="{{ $index + 1 }}">
                        <div class="flex items-start mb-4">
                            <div class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full mr-4 mt-1">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                    {{ $question->question_text }}
                                </h3>
                                
                                <div class="space-y-3">
                                    @foreach($question->options as $option)
                                        <label class="flex items-center p-3 border rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-200 option-label">
                                            <input type="radio" 
                                                   name="answers[{{ $question->id }}]" 
                                                   value="{{ $option->id }}" 
                                                   class="mr-3 text-blue-600 focus:ring-blue-500 option-input"
                                                   data-question="{{ $index + 1 }}"
                                                   required>
                                            <span class="text-gray-700">{{ $option->option_text }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Submit Button -->
                <div class="bg-white shadow-md rounded-lg p-6">
                    <div class="text-center">
                        <div class="mb-4">
                            <p class="text-gray-600">Pastikan semua pertanyaan telah dijawab sebelum mengirim.</p>
                            <p class="text-sm text-red-500 mt-2" id="incomplete-message" style="display: none;">
                                Masih ada pertanyaan yang belum dijawab!
                            </p>
                        </div>
                        
                        <button type="button" 
                                id="submit-btn" 
                                onclick="confirmSubmit()"
                                class="bg-green-600 text-white px-8 py-3 rounded-lg hover:bg-green-700 transition-colors duration-200 font-medium">
                            Kirim Jawaban
                        </button>
                        
                        <div class="mt-4">
                            <a href="{{ route('user.assessments') }}" 
                               class="text-gray-500 hover:text-gray-700 text-sm">
                                ← Kembali ke Daftar Asesmen
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirm-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md mx-4">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Pengiriman</h3>
        <p class="text-gray-600 mb-6">
            Apakah Anda yakin ingin mengirim jawaban? Setelah dikirim, Anda tidak dapat mengubah jawaban lagi.
        </p>
        <div class="flex justify-end space-x-3">
            <button type="button" 
                    onclick="closeModal()" 
                    class="px-4 py-2 text-gray-500 hover:text-gray-700">
                Batal
            </button>
            <button type="button" 
                    onclick="submitForm()" 
                    class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                Ya, Kirim
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const totalQuestions = {{ $questions->count() }};
    let answeredQuestions = 0;

    // Update progress when option is selected
    document.querySelectorAll('.option-input').forEach(input => {
        input.addEventListener('change', function() {
            updateProgress();
            
            // Visual feedback for selected option
            const questionCard = this.closest('.question-card');
            const labels = questionCard.querySelectorAll('.option-label');
            labels.forEach(label => label.classList.remove('border-blue-500', 'bg-blue-50'));
            
            this.closest('.option-label').classList.add('border-blue-500', 'bg-blue-50');
        });
    });

    function updateProgress() {
        // Count answered questions
        const questionNumbers = new Set();
        document.querySelectorAll('.option-input:checked').forEach(input => {
            questionNumbers.add(input.dataset.question);
        });
        
        answeredQuestions = questionNumbers.size;
        const progressPercentage = (answeredQuestions / totalQuestions) * 100;
        
        document.getElementById('progress-bar').style.width = progressPercentage + '%';
        document.getElementById('progress-text').textContent = `${answeredQuestions} dari ${totalQuestions}`;
        
        // Update submit button state
        const submitBtn = document.getElementById('submit-btn');
        const incompleteMsg = document.getElementById('incomplete-message');
        
        if (answeredQuestions === totalQuestions) {
            submitBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
            submitBtn.classList.add('bg-green-600', 'hover:bg-green-700');
            incompleteMsg.style.display = 'none';
        } else {
            incompleteMsg.style.display = 'block';
        }
    }

    function confirmSubmit() {
        if (answeredQuestions < totalQuestions) {
            alert('Mohon jawab semua pertanyaan sebelum mengirim!');
            return;
        }
        
        document.getElementById('confirm-modal').classList.remove('hidden');
        document.getElementById('confirm-modal').classList.add('flex');
    }

    function closeModal() {
        document.getElementById('confirm-modal').classList.add('hidden');
        document.getElementById('confirm-modal').classList.remove('flex');
    }

    function submitForm() {
        const submitBtn = document.getElementById('submit-btn');
        submitBtn.textContent = 'Mengirim...';
        submitBtn.disabled = true;
        
        document.getElementById('assessment-form').submit();
    }

    // Prevent accidental page reload
    window.addEventListener('beforeunload', function(e) {
        if (answeredQuestions > 0 && answeredQuestions < totalQuestions) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    // Auto-save to localStorage (optional - for recovery)
    function autoSave() {
        const formData = new FormData(document.getElementById('assessment-form'));
        const answers = {};
        
        for (let [key, value] of formData.entries()) {
            if (key.startsWith('answers[')) {
                answers[key] = value;
            }
        }
        
        localStorage.setItem('assessment_' + {{ $assessment->id }}, JSON.stringify(answers));
    }

    // Load saved answers (optional)
    function loadSavedAnswers() {
        const saved = localStorage.getItem('assessment_' + {{ $assessment->id }});
        if (saved) {
            const answers = JSON.parse(saved);
            for (let [key, value] of Object.entries(answers)) {
                const input = document.querySelector(`input[name="${key}"][value="${value}"]`);
                if (input) {
                    input.checked = true;
                    input.dispatchEvent(new Event('change'));
                }
            }
        }
    }

    // Save answers periodically
    setInterval(autoSave, 30000); // Save every 30 seconds

    // Load saved answers on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadSavedAnswers();
        updateProgress();
    });

    // Clear saved data on form submit
    document.getElementById('assessment-form').addEventListener('submit', function() {
        localStorage.removeItem('assessment_' + {{ $assessment->id }});
    });
</script>
@endsection