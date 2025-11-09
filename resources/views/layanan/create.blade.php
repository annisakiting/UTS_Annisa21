@extends('layouts.app')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Layanan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    {{-- Tampilkan error validasi --}}
                    @if ($errors->any())
                        <div class_alert="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('layanan.store') }}" method="POST">
                        @csrf 

                        {{-- Nama Layanan --}}
                        <div class="mb-4">
                            <label for="service_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nama Layanan*</label>
                            <input type="text" 
                                   id="service_name" 
                                   name="service_name" 
                                   value="{{ old('service_name') }}" 
                                   placeholder="Contoh: Kemeja Lengan Panjang"
                                   required
                                   class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        </div>

                        {{-- Harga Dasar --}}
                        <div class="mb-4">
                            <label for="base_price" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Harga Dasar (Rp)*</label>
                            <input type="number" 
                                   id="base_price" 
                                   name="base_price" 
                                   value="{{ old('base_price') }}" 
                                   placeholder="Contoh: 150000"
                                   min="0"
                                   required
                                   class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('layanan.index') }}" class="mr-4 text-gray-600 dark:text-gray-400 hover:text-gray-900">
                                Batal
                            </a>
                            
                            {{-- Tombol Simpan (Primary) --}}
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Simpan Layanan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection