@extends('layouts.app')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Ukuran Baru untuk ') }} {{ $customer->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('pelanggan.ukuran.store', $customer->id) }}" method="POST">
                @csrf
                
                {{-- Nama Ukuran --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <label for="measurement_name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nama Ukuran*</label>
                        <input type="text" 
                               id="measurement_name" 
                               name="measurement_name" 
                               value="{{ old('measurement_name') }}"
                               placeholder="Contoh: Kemeja Batik, Celana Kerja" 
                               required
                               class="mt-1 block w-full md:w-1/2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm @error('measurement_name') border-red-500 @enderror">
                        @error('measurement_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- KARTU UNTUK ATASAN --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium mb-4">Ukuran Atasan (Kemeja, Baju, dll)</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div>
                                <label for="lingkar_dada" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Lingkar Dada (cm)</label>
                                <input type="number" step="any" name="lingkar_dada" value="{{ old('lingkar_dada') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label for="panjang_lengan" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Panjang Lengan (cm)</label>
                                <input type="number" step="any" name="panjang_lengan" value="{{ old('panjang_lengan') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label for="lebar_bahu" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Lebar Bahu (cm)</label>
                                <input type="number" step="any" name="lebar_bahu" value="{{ old('lebar_bahu') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label for="panjang_baju" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Panjang Baju (cm)</label>
                                <input type="number" step="any" name="panjang_baju" value="{{ old('panjang_baju') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KARTU UNTUK BAWAHAN --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium mb-4">Ukuran Bawahan (Celana, Rok, dll)</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div>
                                <label for="lingkar_pinggang" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Lingkar Pinggang (cm)</label>
                                <input type="number" step="any" name="lingkar_pinggang" value="{{ old('lingkar_pinggang') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label for="lingkar_panggul" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Lingkar Panggul (cm)</label>
                                <input type="number" step="any" name="lingkar_panggul" value="{{ old('lingkar_panggul') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label for="panjang_celana" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Panjang Celana/Rok (cm)</label>
                                <input type="number" step="any" name="panjang_celana" value="{{ old('panjang_celana') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label for="lingkar_paha" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Lingkar Paha (cm)</label>
                                <input type="number" step="any" name="lingkar_paha" value="{{ old('lingkar_paha') }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a href="{{ route('pelanggan.ukuran.index', $customer->id) }}" class="mr-4 text-gray-600 dark:text-gray-400 hover:text-gray-900">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Simpan Data Ukuran
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection