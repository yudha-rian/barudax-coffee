<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // --- DAFTAR KOLOM YANG BOLEH DIISI ---
    protected $fillable = [
        'order_id',
        'menu_name',
        'price',
        'quantity',
        'note'
    ];

    // Relasi ke tabel order utama
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}