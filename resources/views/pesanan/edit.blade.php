@extends('layouts.app')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Pesanan #') }}{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('pesanan.update', $order->id) }}" method="POST" id="order-form">
                @csrf
                @method('PUT')
                
                {{-- Tampilkan error --}}
                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
                        {{ session('error') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- KARTU 1: DETAIL UTAMA PESANAN --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium mb-4">Detail Pesanan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="customer_id" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Pelanggan*</label>
                                <select id="customer_id" name="customer_id" required class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ old('customer_id', $order->customer_id) == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }} ({{ $customer->phone_number }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="order_date" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Tanggal Pesan*</label>
                                <input type="date" id="order_date" name="order_date" value="{{ old('order_date', $order->order_date) }}" required class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label for="due_date" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Tanggal Selesai (Estimasi)</label>
                                <input type="date" id="due_date" name="due_date" value="{{ old('due_date', $order->due_date) }}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label for="down_payment" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Uang Muka (DP)</label>
                                <input type="number" id="down_payment" name="down_payment" value="{{ old('down_payment', $order->down_payment) }}" min="0" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            </div>
                            <div>
                                <label for="status" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Status Pesanan*</label>
                                <select id="status" name="status" required class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    @foreach (['Pending', 'Cutting', 'Sewing', 'Finishing', 'Ready', 'Completed'] as $status)
                                        <option value="{{ $status }}" {{ old('status', $order->status) == $status ? 'selected' : '' }}>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label for="notes" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Catatan</label>
                                <textarea id="notes" name="notes" rows="2" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('notes', $order->notes) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KARTU 2: ITEM LAYANAN --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium mb-4">Item Layanan</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 border-b dark:border-gray-700 pb-4">
                            <div class="col-span-2">
                                <label for="service-list" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Pilih Layanan</label>
                                <select id="service-list" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="" disabled selected>-- Pilih layanan untuk ditambahkan --</option>
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}" data-price="{{ $service->base_price }}" data-name="{{ $service->service_name }}">
                                            {{ $service->service_name }} (Rp {{ number_format($service->base_price, 0, ',', '.') }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="pt-5">
                                <button type="button" id="btn-add-item" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:border-green-700 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    + Tambahkan ke Pesanan
                                </button>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Layanan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kuantitas</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Harga Satuan</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Subtotal</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="order-items-table" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    {{-- Loop item yang sudah ada --}}
                                    @foreach ($order->items as $index => $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $item->service->service_name ?? 'Layanan Dihapus' }}
                                            <input type="hidden" name="items[{{ $index }}][service_id]" value="{{ $item->service_id }}">
                                        </td>
                                        <td class="px-6 py-4">
                                            <input type="number" class="item-quantity w-20 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" name="items[{{ $index }}][quantity]" value="{{ $item->quantity }}" min="1">
                                        </td>
                                        <td class="px-6 py-4">
                                            <input type="number" class="item-price w-32 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" name="items[{{ $index }}][price_per_item]" value="{{ $item->price_per_item }}" min="0">
                                        </td>
                                        <td class="item-subtotal px-6 py-4 whitespace-nowrap text-right">
                                            {{-- Dihitung JS --}}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <button type="button" class="btn-remove-item text-red-600 hover:text-red-900">Hapus</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="px-6 py-3 text-right font-bold">Total Harga</td>
                                        <td colspan="2" class="px-6 py-3 text-right font-bold"><span id="total-price-display">Rp 0</span></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-4 mb-4 sm:px-6 lg:px-8">
                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

{{-- PENTING: JavaScript untuk form dinamis --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    const btnAddItem = document.getElementById('btn-add-item');
    const serviceList = document.getElementById('service-list');
    const tableBody = document.getElementById('order-items-table');
    const totalPriceDisplay = document.getElementById('total-price-display');
    let itemCounter = {{ $order->items->count() }}; // Mulai counter dari jumlah item yang ada

    function formatRupiah(number) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
    }

    function updateTotalPrice() {
        let total = 0;
        tableBody.querySelectorAll('tr').forEach(row => {
            const qty = parseFloat(row.querySelector('.item-quantity').value) || 0;
            const price = parseFloat(row.querySelector('.item-price').value) || 0;
            const subtotal = qty * price;
            
            row.querySelector('.item-subtotal').textContent = formatRupiah(subtotal);
            total += subtotal;
        });
        totalPriceDisplay.textContent = formatRupiah(total);
    }

    btnAddItem.addEventListener('click', function() {
        const selectedOption = serviceList.options[serviceList.selectedIndex];
        if (!selectedOption || selectedOption.value === "") {
            alert('Silakan pilih layanan terlebih dahulu.');
            return;
        }

        const serviceId = selectedOption.value;
        const serviceName = selectedOption.getAttribute('data-name');
        const servicePrice = parseFloat(selectedOption.getAttribute('data-price'));

        const newRowHtml = `
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    ${serviceName}
                    <input type="hidden" name="items[${itemCounter}][service_id]" value="${serviceId}">
                </td>
                <td class="px-6 py-4">
                    <input type="number" class="item-quantity w-20 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" name="items[${itemCounter}][quantity]" value="1" min="1">
                </td>
                <td class="px-6 py-4">
                    <input type="number" class="item-price w-32 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" name="items[${itemCounter}][price_per_item]" value="${servicePrice}" min="0">
                </td>
                <td class="item-subtotal px-6 py-4 whitespace-nowrap text-right">
                    ${formatRupiah(servicePrice)}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center">
                    <button type="button" class="btn-remove-item text-red-600 hover:text-red-900">Hapus</button>
                </td>
            </tr>
        `;

        tableBody.insertAdjacentHTML('beforeend', newRowHtml);
        itemCounter++;
        updateTotalPrice();
    });

    tableBody.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-remove-item')) {
            e.target.closest('tr').remove();
            updateTotalPrice();
        }
    });

    tableBody.addEventListener('input', function(e) {
        if (e.target.classList.contains('item-quantity') || e.target.classList.contains('item-price')) {
            updateTotalPrice();
        }
    });

    // Panggil saat halaman dimuat untuk menghitung total awal
    updateTotalPrice(); 
});
</script>
@endpush