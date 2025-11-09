@extends('layouts.app')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data Ukuran untuk: ') }} {{ $customer->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Tombol Tambah dan Kembali -->
            <div class="flex justify-between items-center mb-4">
                <a href="{{ route('pelanggan.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    &larr; Kembali ke Pelanggan
                </a>
                <a href="{{ route('pelanggan.ukuran.create', $customer->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    + Tambah Data Ukuran Baru
                </a>
            </div>

            <!-- Notifikasi Sukses -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Konten (Data Ukuran) -->
            @forelse ($measurements as $measurement)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        
                        {{-- Header Card (Nama Ukuran & Tombol Aksi) --}}
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="text-lg font-medium">{{ $measurement->measurement_name }}</h3>
                            <div class="flex-shrink-0">
                                <a href="{{ route('ukuran.edit', $measurement->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-2">Edit</a>
                                <form action="{{ route('ukuran.destroy', $measurement->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data ukuran ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                </form>
                            </div>
                        </div>

                        {{-- Detail Ukuran (dari JSON) --}}
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach ($measurement->details as $key => $value)
                                @if(!empty($value)) {{-- Hanya tampilkan jika ada isinya --}}
                                <div>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ ucwords(str_replace('_', ' ', $key)) }}</span>
                                    <p class="font-semibold">{{ $value }} cm</p>
                                </div>
                                @endif
                            @endforeach
                        </div>

                    </div>
                </div>
            @empty
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 text-center">
                        Belum ada data ukuran untuk pelanggan ini.
                    </div>
                </div>
            @endforelse

        </div>
    </div>
@endsection