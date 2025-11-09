<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard utama.
     */
    public function index()
    {
        // 1. Hitung Jumlah Pelanggan
        $totalCustomers = Customer::count();

        // 2. Hitung Jumlah Layanan
        $totalServices = Service::count();

        // 3. Hitung Pesanan Pending
        $pendingOrders = Order::where('status', 'Pending')->count();

        // 4. Hitung Pesanan Selesai
        $completedOrders = Order::where('status', 'Completed')->count();
        
        // 5. Ambil 5 pesanan terbaru (untuk ditampilkan di tabel)
        $recentOrders = Order::with('customer')
                             ->orderBy('order_date', 'desc')
                             ->limit(5)
                             ->get();

        // Kirim semua data ini ke view 'dashboard'
        return view('dashboard', compact(
            'totalCustomers',
            'totalServices',
            'pendingOrders',
            'completedOrders',
            'recentOrders'
        ));
    }
}