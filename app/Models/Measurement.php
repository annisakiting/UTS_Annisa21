<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'measurement_name', 'details'];

    // Cast 'details' dari JSON ke Array/Object PHP secara otomatis
    protected $casts = [
        'details' => 'array',
    ];

    // Relasi: Satu data ukuran milik satu customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}