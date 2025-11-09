<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone_number', 'address'];

    // Relasi: Satu customer bisa punya banyak pesanan
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Relasi: Satu customer bisa punya banyak data ukuran
    public function measurements()
    {
        return $this->hasMany(Measurement::class);
    }
}