<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <-- PENTING: Untuk Database Transaction
use Exception; // <-- PENTING: Untuk menangkap error

class OrderController extends Controller
{
    /**
     * Tampilkan daftar semua pesanan.
     */
    public function index()
    {
        // Ambil pesanan, urutkan dari yang terbaru
        // 'with('customer')' untuk Eager Loading,
        // mengambil data customer agar query lebih efisien
        $orders = Order::with('customer')
                       ->orderBy('order_date', 'desc')
                       ->get();

        return view('pesanan.index', compact('orders'));
    }

    /**
     * Tampilkan form untuk membuat pesanan baru.
     */
    public function create()
    {
        // Kita butuh daftar pelanggan dan layanan untuk ditampilkan di form
        $customers = Customer::orderBy('name', 'asc')->get();
        $services = Service::orderBy('service_name', 'asc')->get();

        return view('pesanan.create', compact('customers', 'services'));
    }

    /**
     * Simpan pesanan baru ke database.
     * Ini fungsi yang kompleks.
     */
    public function store(Request $request)
    {
        // 1. Validasi data utama
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:order_date',
            'down_payment' => 'nullable|numeric|min:0',
            'items' => 'required|array|min:1', // Pastikan 'items' ada dan tidak kosong
            'items.*.service_id' => 'required|exists:services,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price_per_item' => 'required|numeric|min:0',
        ]);

        // 2. Mulai Database Transaction
        DB::beginTransaction();

        try {
            // 3. Buat Pesanan Utama (Order)
            $order = Order::create([
                'customer_id' => $request->customer_id,
                'order_date' => $request->order_date,
                'due_date' => $request->due_date,
                'down_payment' => $request->down_payment ?? 0,
                'notes' => $request->notes,
                'status' => 'Pending', // Status default
                'total_price' => 0, // Dihitung nanti
            ]);

            $totalPrice = 0;

            // 4. Loop dan simpan Item Pesanan (Order Items)
            foreach ($request->items as $item) {
                $order->items()->create([
                    'service_id' => $item['service_id'],
                    'quantity' => $item['quantity'],
                    'price_per_item' => $item['price_per_item'],
                ]);

                // 5. Hitung total harga
                $totalPrice += $item['quantity'] * $item['price_per_item'];
            }

            // 6. Update total harga di pesanan utama
            $order->total_price = $totalPrice;
            $order->save();

            // 7. Jika semua berhasil, 'commit' transaction
            DB::commit();

            return redirect()->route('pesanan.index')
                             ->with('success', 'Pesanan baru berhasil dibuat.');

        } catch (Exception $e) {
            // 8. Jika ada error, batalkan semua (rollback)
            DB::rollBack();

            // Tampilkan pesan error
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Gagal menyimpan pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan detail satu pesanan.
     */
    public function show(string $id)
    {
        // Ambil data order, customer, dan items (beserta relasi service di dalam items)
        $order = Order::with(['customer', 'items.service'])->findOrFail($id);

        return view('pesanan.show', compact('order'));
    }

    /**
     * Tampilkan form untuk mengedit pesanan.
     * (Ini akan mirip dengan 'create' tapi lebih kompleks)
     */
    public function edit(string $id)
    {
        $order = Order::with('items')->findOrFail($id);
        $customers = Customer::orderBy('name', 'asc')->get();
        $services = Service::orderBy('service_name', 'asc')->get();

        return view('pesanan.edit', compact('order', 'customers', 'services'));
    }

    /**
     * Update data pesanan di database.
     * (Ini juga sangat kompleks)
     */
    public function update(Request $request, string $id)
    {
        // 1. Validasi
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:order_date',
            'status' => 'required|in:Pending,Cutting,Sewing,Finishing,Ready,Completed',
            'down_payment' => 'nullable|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.service_id' => 'required|exists:services,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price_per_item' => 'required|numeric|min:0',
        ]);

        $order = Order::findOrFail($id);

        // 2. Mulai Transaction
        DB::beginTransaction();

        try {
            // 3. Update data pesanan utama
            $order->update([
                'customer_id' => $request->customer_id,
                'order_date' => $request->order_date,
                'due_date' => $request->due_date,
                'down_payment' => $request->down_payment ?? 0,
                'status' => $request->status,
                'notes' => $request->notes,
            ]);

            // 4. Hapus semua item pesanan lama
            // (Ini cara paling mudah. Cara yang lebih 'canggih'
            // adalah mencocokkan ID, tapi ini jauh lebih kompleks)
            $order->items()->delete();

            $totalPrice = 0;

            // 5. Buat ulang item pesanan dari data form
            foreach ($request->items as $item) {
                $order->items()->create([
                    'service_id' => $item['service_id'],
                    'quantity' => $item['quantity'],
                    'price_per_item' => $item['price_per_item'],
                ]);

                // 6. Hitung total harga baru
                $totalPrice += $item['quantity'] * $item['price_per_item'];
            }

            // 7. Update total harga baru
            $order->total_price = $totalPrice;
            $order->save();

            // 8. Commit
            DB::commit();

            return redirect()->route('pesanan.index')
                             ->with('success', 'Pesanan berhasil diperbarui.');

        } catch (Exception $e) {
            // 9. Rollback jika gagal
            DB::rollBack();
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Gagal memperbarui pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Hapus pesanan dari database.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);

        // Hapus pesanan.
        // Berkat 'onDelete('cascade')' di migration/SQL,
        // semua 'order_items' yang terkait akan ikut terhapus.
        $order->delete();

        return redirect()->route('pesanan.index')
                         ->with('success', 'Pesanan berhasil dihapus.');
    }
}