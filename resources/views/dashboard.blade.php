@extends('layouts.app')

@section('title', 'Dashboard Admin - Sistem Asesmen Gamifikasi')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
    <p class="text-gray-600">Selamat datang, {{ $username }}!</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-lg font-semibold text-gray-700">Total Pengguna</h2>
                <p class="text-2xl font-bold text-gray-800">{{ $totalUsers }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-lg font-semibold text-gray-700">Total Asesmen</h2>
                <p class="text-2xl font-bold text-gray-800">{{ $totalAssessments }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-lg font-semibold text-gray-700">Sesi Selesai bulan ini</h2>
                <p class="text-2xl font-bold text-gray-800">{{ $totalCompletedSessions }}</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow-md p-6 mb-8">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Sesi Asesmen Terkini</h2>
    
    @if($recentSessions->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Pengguna</th>
                        <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Asesmen</th>
                        <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentSessions as $session)
                        <tr>
                            <td class="py-3 px-4 border-b border-gray-200">
                                <div class="text-sm leading-5 font-medium text-gray-900">{{ $session->user->name }}</div>
                                <div class="text-sm leading-5 text-gray-500">{{ $session->user->email }}</div>
                            </td>
                            <td class="py-3 px-4 border-b border-gray-200">
                                <div class="text-sm leading-5 text-gray-900">{{ $session->assessment->name }}</div>
                            </td>
                            <td class="py-3 px-4 border-b border-gray-200 text-sm leading-5 text-gray-500">
                                {{ $session->taken_at->format('d M Y, H:i') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-600">Belum ada sesi asesmen yang tercatat.</p>
    @endif
</div>


 <div class="bg-white rounded-lg shadow-md p-6 mb-8">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Daftar Data Pengguna</h2>

    @if($users->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Lahir</th>
                        <th class="py-3 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Kelamin</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="py-3 px-4 border-b border-gray-200 text-sm font-medium text-gray-900">{{ $user->name }}</td>
                            <td class="py-3 px-4 border-b border-gray-200 text-sm text-gray-500">{{ $user->email }}</td>
                            <td class="py-3 px-4 border-b border-gray-200 text-sm text-gray-500">{{ $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('d M Y') : '-' }}</td>
                            <td class="py-3 px-4 border-b border-gray-200 text-sm text-gray-500">{{ $user->gender ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-600">Belum ada pengguna yang terdaftar.</p>
    @endif
</div>

<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-xl font-semibold text-gray-800 mb-4">Asesmen</h2>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <a href="{{ route('admin.assessments') }}" class="bg-indigo-100 hover:bg-indigo-200 text-indigo-700 p-4 rounded-lg flex items-center transition">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
            </svg>
            Kelola Asesmen
        </a>
        
        <a href="{{ route('admin.assessments.create') }}" class="bg-green-100 hover:bg-green-200 text-green-700 p-4 rounded-lg flex items-center transition">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Buat Asesmen Baru
        </a>
    </div>
</div>
@endsection