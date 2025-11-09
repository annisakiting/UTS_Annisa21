<?php

namespace App\Http\Controllers;

use App\Models\Customer;    // <-- Panggil model Customer
use App\Models\Measurement; // <-- Panggil model Measurement
use Illuminate\Http\Request;

class MeasurementController extends Controller
{
    /**
     * Tampilkan semua ukuran milik 1 pelanggan
     */
    public function index(Customer $customer)
    {
        // Ambil semua data ukuran yang customer_id-nya = $customer->id
        $measurements = Measurement::where('customer_id', $customer->id)
                                    ->orderBy('measurement_name', 'asc')
                                    ->get();
        
        // Kirim data $customer dan $measurements ke view
        return view('ukuran.index', compact('customer', 'measurements'));
    }

    /**
     * Tampilkan form tambah ukuran untuk 1 pelanggan
     */
    public function create(Customer $customer)
    {
        // Kita cuma perlu kirim data $customer
        return view('ukuran.create', compact('customer'));
    }

    /**
     * Simpan data ukuran baru
     */
    public function store(Request $request, Customer $customer)
    {
        // 1. Validasi nama ukuran
        $request->validate([
            'measurement_name' => 'required|string|max:255',
        ]);

        // 2. Kumpulkan semua data ukuran dari form
        //    (kecuali _token dan measurement_name)
        $details = $request->except(['_token', 'measurement_name']);

        // 3. Simpan ke database
        Measurement::create([
            'customer_id' => $customer->id,
            'measurement_name' => $request->measurement_name,
            'details' => $details // <-- $details akan otomatis diubah jadi JSON oleh Model
        ]);

        // 4. Redirect kembali ke halaman index ukuran
        return redirect()->route('pelanggan.ukuran.index', $customer->id)
                         ->with('success', 'Data ukuran baru berhasil disimpan.');
    }

    /**
     * Tampilkan form edit ukuran
     */
    public function edit(Measurement $measurement)
    {
        // Kita tidak perlu $customer di sini, 
        // karena $measurement sudah punya relasi ke customer
        // $measurement->customer->name (bisa dipakai di view)

        // Tampilkan view
        return view('ukuran.edit', compact('measurement'));
    }

    /**
     * Update data ukuran
     */
    public function update(Request $request, Measurement $measurement)
    {
        // 1. Validasi nama
        $request->validate([
            'measurement_name' => 'required|string|max:255',
        ]);

        // 2. Kumpulkan data ukuran dari form
        $details = $request->except(['_token', '_method', 'measurement_name']);

        // 3. Update data
        $measurement->update([
            'measurement_name' => $request->measurement_name,
            'details' => $details // <-- Data JSON di-update
        ]);

        // 4. Redirect kembali ke halaman index ukuran milik customer
        //    ($measurement->customer_id)
        return redirect()->route('pelanggan.ukuran.index', $measurement->customer_id)
                         ->with('success', 'Data ukuran berhasil diperbarui.');
    }

    /**
     * Hapus data ukuran
     */
    public function destroy(Measurement $measurement)
    {
        // Simpan customer_id dulu untuk redirect
        $customerId = $measurement->customer_id;
        
        // Hapus data
        $measurement->delete();

        // Redirect
        return redirect()->route('pelanggan.ukuran.index', $customerId)
                         ->with('success', 'Data ukuran berhasil dihapus.');
    }
}