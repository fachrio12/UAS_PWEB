@extends('layouts.app')

@section('title', 'Pengelolaan Asesmen')

@section('content')
<div class="min-h-screen bg-gray-100 py-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Daftar Asesmen</h2>

            @if($assessments->isEmpty())
                <div class="text-center text-gray-600">
                    Belum ada asesmen yang dibuat.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Nama Asesmen</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Deskripsi</th>
                                <th class="px-4 py-2 text-center text-sm font-semibold text-gray-700">Jumlah Pertanyaan</th>
                                <th class="px-4 py-2 text-center text-sm font-semibold text-gray-700">Tanggal Dibuat</th> {{-- Tambahan --}}
                                <th class="px-4 py-2 text-center text-sm font-semibold text-gray-700">Status</th>
                                <th class="px-4 py-2 text-center text-sm font-semibold text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($assessments as $assessment)
                                <tr class="bg-white hover:bg-blue-50 transition">
                                    <td class="px-4 py-2 text-sm text-gray-800">{{ $assessment->name }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-600">{{ $assessment->description }}</td>
                                    <td class="px-4 py-2 text-center text-sm text-gray-800">{{ $assessment->questions_count }}</td>
                                    <td class="px-4 py-2 text-center text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($assessment->date_created)->translatedFormat('d M Y') }}
                                    </td> {{-- Tanggal Dibuat --}}
                                    <td class="px-4 py-2 text-center text-sm">
                                        @if($assessment->is_active)
                                            <span class="inline-block px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Aktif</span>
                                        @else
                                            <span class="inline-block px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-center text-sm relative">
                                        <div class="inline-block text-left">
                                            <button type="button" class="text-blue-600 hover:underline focus:outline-none" onclick="toggleDropdown({{ $assessment->id }})">
                                                Edit
                                            </button>
                                            <div id="dropdown-{{ $assessment->id }}" class="hidden absolute right-0 z-10 mt-2 w-40 bg-white border border-gray-200 rounded-md shadow-lg">
                                                <form method="POST" action="{{ route('admin.assessments.update', $assessment->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="is_active" value="1">
                                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-green-700 hover:bg-green-50">
                                                        Aktifkan
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('admin.assessments.update', $assessment->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="is_active" value="0">
                                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-red-50">
                                                        Nonaktifkan
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleDropdown(id) {
        const dropdown = document.getElementById('dropdown-' + id);
        dropdown.classList.toggle('hidden');
    }

    // Optional: Hide other dropdowns if one is opened
    document.addEventListener('click', function(event) {
        document.querySelectorAll('[id^="dropdown-"]').forEach(drop => {
            if (!drop.contains(event.target) && !event.target.closest('button')) {
                drop.classList.add('hidden');
            }
        });
    });
</script>
@endsection
