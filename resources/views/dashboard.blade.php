<x-app-layout>
    {{-- Ini adalah Header Halaman (judul) --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- Ini adalah Konten Halaman --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- KODE DASHBOARD KUSTOM KITA MULAI DARI SINI --}}
                    
                    <div class="mb-4">
                        <h3 class="text-lg font-medium">Selamat Datang di Aplikasi Penjahit!</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Berikut adalah ringkasan bisnis Anda saat ini.</p>
                    </div>

                    {{-- 1. KARTU RINGKASAN --}}
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <div class="bg-blue-500 text-white p-4 rounded-lg shadow">
                            <h5 class="font-bold">Total Pelanggan</h5>
                            <p class="text-3xl font-bold">{{ $totalCustomers }}</p>
                        </div>
                        <div class="bg-yellow-500 text-white p-4 rounded-lg shadow">
                            <h5 class="font-bold">Pesanan Pending</h5>
                            <p class="text-3xl font-bold">{{ $pendingOrders }}</p>
                        </div>
                        <div class="bg-green-500 text-white p-4 rounded-lg shadow">
                            <h5 class="font-bold">Pesanan Selesai</h5>
                            <p class="text-3xl font-bold">{{ $completedOrders }}</p>
                        </div>
                        <div class="bg-indigo-500 text-white p-4 rounded-lg shadow">
                            <h5 class="font-bold">Total Layanan</h5>
                            <p class="text-3xl font-bold">{{ $totalServices }}</p>
                        </div>
                    </div>

                    {{-- 2. TABEL PESANAN TERBARU --}}
                    <div>
                        <h4 class="text-lg font-medium mb-2">5 Pesanan Terbaru</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pelanggan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tgl Pesan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse ($recentOrders as $order)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">#{{ $order->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->customer->name ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-200 text-gray-800">{{ $order->status }}</span></td>
                                            <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <a href="{{ route('pesanan.show', $order->id) }}" class="text-indigo-600 hover:text-indigo-900">Lihat Nota</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">Belum ada pesanan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>