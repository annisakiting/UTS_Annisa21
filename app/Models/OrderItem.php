<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = ['order_id', 'service_id', 'quantity', 'price_per_item'];

    /**
     * =======================================================
     * TAMBAHKAN FUNGSI INI
     * =======================================================
     * Relasi: Satu item pesanan ('OrderItem') milik satu layanan ('Service')
     */
    public function service()
    {
        // Kita beritahu: kolom 'service_id' di tabel ini 
        // terhubung ke 'id' di tabel 'services'
        return $this->belongsTo(Service::class);
    }
}