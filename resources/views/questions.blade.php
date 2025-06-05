@extends('layouts.app')

@section('title', 'Tambah Pertanyaan')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-3xl bg-white shadow-md rounded-lg p-8">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
            Tambahkan Pertanyaan untuk: <span class="text-blue-600">{{ $assessment->name }}</span>
        </h2>

        <form action="{{ route('admin.questions.multi_store') }}" method="POST">
            @csrf
            <input type="hidden" name="assessment_id" value="{{ $assessment->id }}">

            <div id="questions-wrapper">
                <div class="question-block mb-6 border-t pt-4 relative">
                    <h4 class="font-semibold text-gray-700 mb-2">Pertanyaan 1</h4>

                    <div class="mb-3">
                        <input type="text" name="questions[0][question_text]" class="w-full border rounded px-3 py-2" placeholder="Masukkan pertanyaan..." required>
                    </div>

                    <div class="option-wrapper">
                        <div class="flex gap-2 mb-2">
                            <input type="text" name="questions[0][options][0][option_text]" class="w-3/4 border rounded px-3 py-2" placeholder="Teks opsi" required>
                            <input type="number" name="questions[0][options][0][score]" class="w-1/4 border rounded px-3 py-2" placeholder="Skor" required>
                        </div>
                    </div>

                    <button type="button" class="text-sm text-blue-600 hover:underline mb-2" onclick="addOption(this)">
                        + Tambah Opsi
                    </button>
                </div>
            </div>

            <button type="button" onclick="addQuestion()" class="text-sm text-purple-600 hover:underline mb-4">
                + Tambah Pertanyaan Baru
            </button>

            <div class="text-center">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
                    Simpan Semua Pertanyaan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let questionIndex = 1;

    function addQuestion() {
        const wrapper = document.getElementById('questions-wrapper');

        const questionBlock = document.createElement('div');
        questionBlock.classList.add('question-block', 'mb-6', 'border-t', 'pt-4', 'relative');

        questionBlock.innerHTML = `
            <button type="button" onclick="removeQuestion(this)" class="absolute top-0 right-0 mt-2 mr-2 text-red-500 hover:text-red-700 text-lg" title="Hapus Pertanyaan">&times;</button>
            <h4 class="font-semibold text-gray-700 mb-2">Pertanyaan</h4>
            <div class="mb-3">
                <input type="text" name="questions[${questionIndex}][question_text]" class="w-full border rounded px-3 py-2" placeholder="Masukkan pertanyaan..." required>
            </div>
            <div class="option-wrapper">
                <div class="flex gap-2 mb-2 items-center">
                    <input type="text" name="questions[${questionIndex}][options][0][option_text]" class="w-3/4 border rounded px-3 py-2" placeholder="Teks opsi" required>
                    <input type="number" name="questions[${questionIndex}][options][0][score]" class="w-1/4 border rounded px-3 py-2" placeholder="Skor" required>
                    <button type="button" onclick="removeOption(this)" class="text-red-500 hover:text-red-700 text-lg">&times;</button>
                </div>
            </div>
            <button type="button" class="text-sm text-blue-600 hover:underline mb-2" onclick="addOption(this)">+ Tambah Opsi</button>
        `;

        wrapper.appendChild(questionBlock);
        questionIndex++;
        updateQuestionNumbers();
    }

    function addOption(button) {
        const questionBlock = button.closest('.question-block');
        const optionWrapper = questionBlock.querySelector('.option-wrapper');

        const qIndex = Array.from(document.querySelectorAll('.question-block')).indexOf(questionBlock);
        const oIndex = optionWrapper.querySelectorAll('.flex').length;

        const newOption = document.createElement('div');
        newOption.classList.add('flex', 'gap-2', 'mb-2', 'items-center');
        newOption.innerHTML = `
            <input type="text" name="questions[${qIndex}][options][${oIndex}][option_text]" class="w-3/4 border rounded px-3 py-2" placeholder="Teks opsi" required>
            <input type="number" name="questions[${qIndex}][options][${oIndex}][score]" class="w-1/4 border rounded px-3 py-2" placeholder="Skor" required>
            <button type="button" onclick="removeOption(this)" class="text-red-500 hover:text-red-700 text-lg">&times;</button>
        `;

        optionWrapper.appendChild(newOption);
    }

    function removeQuestion(button) {
        button.closest('.question-block').remove();
        updateQuestionNumbers();
    }

    function removeOption(button) {
        button.closest('.flex').remove();
    }

    function updateQuestionNumbers() {
        const questionBlocks = document.querySelectorAll('.question-block');
        questionBlocks.forEach((block, index) => {
            const label = block.querySelector('h4');
            label.textContent = `Pertanyaan ${index + 1}`;
        });
    }

    document.querySelector('form').addEventListener('submit', function(e) {
    const questionCount = document.querySelectorAll('.question-block').length;
    if (questionCount === 0) {
        e.preventDefault(); // Batalkan submit
        alert('Tambahkan minimal satu pertanyaan sebelum menyimpan.');
    }
});
</script>

@endsection
