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
                <div class="question-block mb-6 border-t pt-4">
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
        questionBlock.classList.add('question-block', 'mb-6', 'border-t', 'pt-4');

        questionBlock.innerHTML = `
            <h4 class="font-semibold text-gray-700 mb-2">Pertanyaan ${questionIndex + 1}</h4>
            <div class="mb-3">
                <input type="text" name="questions[${questionIndex}][question_text]" class="w-full border rounded px-3 py-2" placeholder="Masukkan pertanyaan..." required>
            </div>
            <div class="mb-3">
                <select name="questions[${questionIndex}][question_type]" class="w-full border rounded px-3 py-2" required>
                    <option disabled selected>Pilih jenis pertanyaan</option>
                    <option value="pilihan_ganda">Pilihan Ganda</option>
                    <option value="skala_likert">Skala Likert</option>
                </select>
            </div>
            <div class="option-wrapper">
                <div class="flex gap-2 mb-2">
                    <input type="text" name="questions[${questionIndex}][options][0][option_text]" class="w-3/4 border rounded px-3 py-2" placeholder="Teks opsi" required>
                    <input type="number" name="questions[${questionIndex}][options][0][score]" class="w-1/4 border rounded px-3 py-2" placeholder="Skor" required>
                </div>
            </div>
            <button type="button" class="text-sm text-blue-600 hover:underline mb-2" onclick="addOption(this)">
                + Tambah Opsi
            </button>
        `;

        wrapper.appendChild(questionBlock);
        questionIndex++;
    }

    function addOption(button) {
        const questionBlock = button.closest('.question-block');
        const optionWrapper = questionBlock.querySelector('.option-wrapper');

        const inputGroups = optionWrapper.querySelectorAll('.flex');
        const qIndex = Array.from(document.querySelectorAll('.question-block')).indexOf(questionBlock);
        const oIndex = inputGroups.length;

        const newOption = document.createElement('div');
        newOption.classList.add('flex', 'gap-2', 'mb-2');
        newOption.innerHTML = `
            <input type="text" name="questions[${qIndex}][options][${oIndex}][option_text]" class="w-3/4 border rounded px-3 py-2" placeholder="Teks opsi" required>
            <input type="number" name="questions[${qIndex}][options][${oIndex}][score]" class="w-1/4 border rounded px-3 py-2" placeholder="Skor" required>
        `;

        optionWrapper.appendChild(newOption);
    }
</script>
@endsection
