@extends('layouts.app')

@section('title', 'Profil Pengguna')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Edit Profil</h2>

        @if (session('success'))
            <div class="mb-4 text-green-600 font-medium text-center">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.profile.update') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Nama:</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border rounded px-3 py-2 mt-1" required>
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Email:</label>
                <p class="text-gray-900">{{ $user->email }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Tanggal Lahir:</label>
                <input type="date" name="birth_date" value="{{ old('birth_date', \Carbon\Carbon::parse($user->birth_date)->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2 mt-1" required>
                @error('birth_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium">Jenis Kelamin:</label>
                <select name="gender" class="w-full border rounded px-3 py-2 mt-1" required>
                    <option value="Laki-laki" {{ $user->gender == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ $user->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('gender') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="text-center">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
