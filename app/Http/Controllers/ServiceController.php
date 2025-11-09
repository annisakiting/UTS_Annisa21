<?php

namespace App\Http\Controllers;

use App\Models\Service;      // <-- Panggil Model Service
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // <-- Untuk validasi update

class ServiceController extends Controller
{
    /**
     * ---------------------------------
     * FUNGSI: Tampilkan semua layanan (READ)
     * ---------------------------------
     * URL: GET /layanan
     * Route Name: layanan.index
     */
    public function index()
    {
        // Ambil semua layanan, urutkan A-Z
        $services = Service::orderBy('service_name', 'asc')->get();

        // Tampilkan view 'layanan/index.blade.php'
        return view('layanan.index', compact('services'));
    }

    /**
     * ---------------------------------
     * FUNGSI: Tampilkan form tambah layanan (CREATE)
     * ---------------------------------
     * URL: GET /layanan/create
     * Route Name: layanan.create
     */
    public function create()
    {
        // Tampilkan view 'layanan/create.blade.php'
        return view('layanan.create');
    }

    /**
     * ---------------------------------
     * FUNGSI: Simpan layanan baru (CREATE)
     * ---------------------------------
     * URL: POST /layanan
     * Route Name: layanan.store
     */
    public function store(Request $request)
    {
        // 1. Validasi data
        $request->validate([
            'service_name' => 'required|string|max:255|unique:services',
            'base_price' => 'required|numeric|min:0',
        ]);

        // 2. Simpan ke database
        Service::create([
            'service_name' => $request->service_name,
            'base_price' => $request->base_price,
        ]);

        // 3. Redirect ke halaman index
        return redirect()->route('layanan.index')
                         ->with('success', 'Layanan baru berhasil ditambahkan.');
    }

    /**
     * ---------------------------------
     * FUNGSI: Tampilkan detail 1 layanan (READ)
     * ---------------------------------
     * URL: GET /layanan/{id}
     * Route Name: layanan.show
     */
    public function show(string $id)
    {
        // (Biasanya tidak terlalu dipakai untuk data master, tapi kita buat saja)
        $service = Service::findOrFail($id);
        return view('layanan.show', compact('service'));
    }

    /**
     * ---------------------------------
     * FUNGSI: Tampilkan form edit layanan (UPDATE)
     * ---------------------------------
     * URL: GET /layanan/{id}/edit
     * Route Name: layanan.edit
     */
    public function edit(string $id)
    {
        // Cari layanan
        $service = Service::findOrFail($id);

        // Tampilkan view 'layanan/edit.blade.php'
        return view('layanan.edit', compact('service'));
    }

    /**
     * ---------------------------------
     * FUNGSI: Simpan perubahan layanan (UPDATE)
     * ---------------------------------
     * URL: PUT/PATCH /layanan/{id}
     * Route Name: layanan.update
     */
    public function update(Request $request, string $id)
    {
        // 1. Validasi
        $request->validate([
            'service_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('services')->ignore($id), // Harus unik, KECUALI untuk ID dia sendiri
            ],
            'base_price' => 'required|numeric|min:0',
        ]);

        // 2. Cari layanan
        $service = Service::findOrFail($id);

        // 3. Update
        $service->update([
            'service_name' => $request->service_name,
            'base_price' => $request->base_price,
        ]);

        // 4. Redirect
        return redirect()->route('layanan.index')
                         ->with('success', 'Data layanan berhasil diperbarui.');
    }

    /**
     * ---------------------------------
     * FUNGSI: Hapus layanan (DELETE)
     * ---------------------------------
     * URL: DELETE /layanan/{id}
     * Route Name: layanan.destroy
     */
    public function destroy(string $id)
    {
        // 1. Cari
        $service = Service::findOrFail($id);

        // 2. Hapus
        $service->delete();

        // 3. Redirect
        return redirect()->route('layanan.index')
                         ->with('success', 'Data layanan berhasil dihapus.');
    }
}