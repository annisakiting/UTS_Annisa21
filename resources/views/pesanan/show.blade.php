@extends('layouts.app')

@section('content')
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detail Pesanan (Nota) #') }}{{ $order->id }}
            </h2>
            
            {{-- Tombol Aksi di Header --}}
            <div>
                {{-- Tombol Print (Sembunyikan saat print) --}}
                <button onclick="window.print()" class="print:hidden inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Cetak Nota
                </button>
                <a href="{{ route('pesanan.index') }}" class="print:hidden ml-2 inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    {{-- CSS Khusus untuk Print --}}
    <style>
        @media print {
            body {
                background: #fff !important;
            }
            .py-12, .max-w-7xl, .sm\:px-6, .lg\:px-8 {
                padding: 0 !important;
                margin: 0 !important;
                max-width: 100% !important;
            }
            .bg-white {
                border: none !important;
                box-shadow: none !important;
            }
            .print\:text-black {
                color: #000 !important;
            }
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-10 text-gray-900 dark:text-gray-100 print:text-black">

                    {{-- BAGIAN KOP NOTA --}}
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h5 class="text-lg font-bold uppercase">App Penjahit</h5>
                            <p class="text-sm">Jl. Pahlawan Kerja No. 123</p>
                            <p class="text-sm">Telepon: 0812-3456-7890</p>
                        </div>
                        <div class="text-right">
                            <h5 class="text-lg font-bold uppercase">Nota Pesanan</h5>
                            <p class="text-sm"><strong>ID Pesanan:</strong> #{{ $order->id }}</p>
                            <p class="text-sm"><strong>Tgl Pesan:</strong> {{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</p>
                        </div>
                    </div>

                    <hr class="border-gray-300 dark:border-gray-700 my-4">

                    {{-- BAGIAN INFO PELANGGAN & STATUS --}}
                    <div class="flex justify-between mb-4">
                        <div>
                            <h6 class="font-semibold">Ditagih Kepada:</h6>
                            <p class="text-sm"><strong>{{ $order->customer->name ?? 'N/A' }}</strong></p>
                            <p class="text-sm">{{ $order->customer->phone_number ?? 'N/A' }}</p>
                            <p class="text-sm">{{ $order->customer->address ?? 'N/A' }}</p>
                        </div>
                        <div class="text-right">
                            <h6 class="font-semibold">Info Pesanan:</h6>
                            <p class="text-sm"><strong>Tgl Selesai (Est.):</strong> {{ $order->due_date ? \Carbon\Carbon::parse($order->due_date)->format('d M Y') : '-' }}</p>
                            <p class="text-sm"><strong>Status:</strong> <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-200 text-gray-800">{{ $order->status }}</span></p>
                        </div>
                    </div>

                    {{-- BAGIAN TABEL ITEM --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No.</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Layanan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kuantitas</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Harga Satuan</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->service->service_name ?? 'Layanan Dihapus' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->quantity }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($item->price_per_item, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">Rp {{ number_format($item->price_per_item * $item->quantity, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- BAGIAN TOTAL HARGA --}}
                    <div class="flex justify-end mt-4">
                        <div class="w-full md:w-1/3">
                            <div class="flex justify-between">
                                <span class="font-semibold">Total Harga</span>
                                <span class="font-semibold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                <span>Uang Muka (DP)</span>
                                <span>Rp {{ number_format($order->down_payment, 0, ',', '.') }}</span>
                            </div>
                            <hr class="border-gray-300 dark:border-gray-700 my-2">
                            <div class="flex justify-between font-bold text-lg">
                                <span>Sisa Bayar</span>
                                <span>Rp {{ number_format($order->total_price - $order->down_payment, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- BAGIAN CATATAN --}}
                    @if($order->notes)
                        <hr class="border-gray-300 dark:border-gray-700 my-4">
                        <div>
                            <strong class="font-semibold">Catatan Pesanan:</strong>
                            <p class="text-sm italic text-gray-600 dark:text-gray-400">{{ $order->notes }}</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection