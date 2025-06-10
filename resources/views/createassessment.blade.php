@extends('layouts.app')

@section('title', 'Tambah Asesmen')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-xl bg-white shadow-md rounded-lg p-8">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Tambah Asesmen</h2>

        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.assessments.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium mb-1">Jenis Assessment</label>
                <select name="name" id="name" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="" disabled selected>Pilih jenis assessment</option>
                    <option value="Minat Bakat">Minat Bakat</option>
                    <option value="Motivasi Belajar">Motivasi Belajar</option>
                    <option value="Gaya Belajar">Gaya Belajar</option>
                    <option value="Kecenderungan Otak (Kanan/Kiri)">Kecenderungan Otak (Kanan/Kiri)</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-medium mb-1">Deskripsi</label>
                <textarea name="description" id="description" rows="4" class="w-full border rounded px-3 py-2" required>{{ old('description') }}</textarea>
            </div>

            <div class="text-center">
                <button type="button" onclick="history.back()" class="bg-red-600 text-white px-5 py-2 rounded hover:bg-red-700 transition">
                    Kembali
                </button>
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">Lanjutkan</button>
            </div>
        </form>
    </div>
</div>
@endsection
