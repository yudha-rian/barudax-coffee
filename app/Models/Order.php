<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // --- BAGIAN INI YANG KURANG TADI ---
    // Daftar kolom yang diizinkan untuk diisi datanya
    protected $fillable = [
    'user_id', // <--- TAMBAHKAN INI
    'customer_name',
    'table_number', 
    'seat_image',
    'total_price',
    'status',
    'payment_proof'
];

// Order dimiliki oleh User
public function user()
{
    return $this->belongsTo(User::class);
}

    // Relasi ke tabel item pesanan
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}