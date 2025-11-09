<?php

namespace App\Http\Controllers;

use App\Models\Customer;    // <-- Pastikan Model Customer dipanggil
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // <-- Kita butuh ini untuk validasi update

class CustomerController extends Controller
{
    /**
     * ---------------------------------
     * FUNGSI: Tampilkan semua pelanggan (READ)
     * ---------------------------------
     * URL: GET /pelanggan
     * Route Name: pelanggan.index
     */
    public function index()
    {
        // Ambil semua data customer, urutkan A-Z
        $customers = Customer::orderBy('name', 'asc')->get();

        // Tampilkan halaman view 'pelanggan/index.blade.php'
        // dan kirim data $customers ke view tersebut
        return view('pelanggan.index', compact('customers'));
    }

    /**
     * ---------------------------------
     * FUNGSI: Tampilkan form tambah pelanggan (CREATE)
     * ---------------------------------
     * URL: GET /pelanggan/create
     * Route Name: pelanggan.create
     */
    public function create()
    {
        // Tampilkan halaman view 'pelanggan/create.blade.php'
        return view('pelanggan.create');
    }

    /**
     * ---------------------------------
     * FUNGSI: Simpan data pelanggan baru (CREATE)
     * ---------------------------------
     * URL: POST /pelanggan
     * Route Name: pelanggan.store
     */
    public function store(Request $request)
    {
        // 1. Validasi data yang masuk
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20|unique:customers', // 'unique:customers' artinya harus unik di tabel customers
            'address' => 'nullable|string',
        ]);

        // 2. Simpan data ke database
        Customer::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ]);

        // 3. Arahkan kembali ke halaman index dengan pesan sukses
        return redirect()->route('pelanggan.index')
                         ->with('success', 'Pelanggan baru berhasil ditambahkan.');
    }

    /**
     * ---------------------------------
     * FUNGSI: Tampilkan detail 1 pelanggan (READ)
     * ---------------------------------
     * URL: GET /pelanggan/{id}
     * Route Name: pelanggan.show
     */
    public function show(string $id)
    {
        // Cari pelanggan berdasarkan ID, kalau tidak ada, tampilkan error 404
        $customer = Customer::findOrFail($id);

        // Tampilkan view 'pelanggan/show.blade.php'
        return view('pelanggan.show', compact('customer'));
    }

    /**
     * ---------------------------------
     * FUNGSI: Tampilkan form edit pelanggan (UPDATE)
     * ---------------------------------
     * URL: GET /pelanggan/{id}/edit
     * Route Name: pelanggan.edit
     */
    public function edit(string $id)
    {
        // Cari pelanggan yang mau diedit
        $customer = Customer::findOrFail($id);

        // Tampilkan view 'pelanggan/edit.blade.php' dan kirim data customer
        return view('pelanggan.edit', compact('customer'));
    }

    /**
     * ---------------------------------
     * FUNGSI: Simpan perubahan data pelanggan (UPDATE)
     * ---------------------------------
     * URL: PUT/PATCH /pelanggan/{id}
     * Route Name: pelanggan.update
     */
    public function update(Request $request, string $id)
    {
        // 1. Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => [
                'required',
                'string',
                'max:20',
                Rule::unique('customers')->ignore($id), // Nomor HP harus unik, KECUALI untuk ID dia sendiri
            ],
            'address' => 'nullable|string',
        ]);

        // 2. Cari data yang mau di-update
        $customer = Customer::findOrFail($id);

        // 3. Update datanya di database
        $customer->update([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ]);

        // 4. Arahkan kembali ke halaman index dengan pesan sukses
        return redirect()->route('pelanggan.index')
                         ->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    /**
     * ---------------------------------
     * FUNGSI: Hapus data pelanggan (DELETE)
     * ---------------------------------
     * URL: DELETE /pelanggan/{id}
     * Route Name: pelanggan.destroy
     */
    public function destroy(string $id)
    {
        // 1. Cari data yang mau dihapus
        $customer = Customer::findOrFail($id);

        // 2. Hapus data
        $customer->delete();

        // 3. Arahkan kembali ke halaman index dengan pesan sukses
        return redirect()->route('pelanggan.index')
                         ->with('success', 'Data pelanggan berhasil dihapus.');
    }
}