<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 
        'order_date', 
        'due_date', 
        'total_price', 
        'down_payment', 
        'status', 
        'notes'
    ];

    // Relasi: Satu pesanan milik satu customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relasi: Satu pesanan punya banyak item pesanan
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relasi: Satu pesanan bisa punya banyak layanan (lewat tabel order_items)
    public function services()
    {
        return $this->belongsToMany(Service::class, 'order_items');
    }
}