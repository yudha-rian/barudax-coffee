<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest; // <--- 1. Import Form Request Baru
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    // 1. Fungsi Menambah Menu ke Keranjang (Session)
    public function addToCart(Request $request, $id)
    {
        $menu = Menu::find($id);

        // Ambil keranjang lama atau buat array baru jika kosong
        $cart = session()->get('cart', []);

        // Data yang akan disimpan
        $cart[] = [
            'id' => $menu->id,
            'name' => $menu->name,
            'price' => $menu->price,
            'quantity' => $request->quantity,
            'note' => $request->note,
            'image' => $menu->image
        ];

        // Simpan kembali ke session
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Menu berhasil masuk keranjang!');
    }

    // 2. Halaman Checkout (Form Order)
    public function checkout()
    {
        $cart = session()->get('cart', []);

        // Hitung Total Bayar
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('checkout', compact('cart', 'total'));
    }

    // 3. Proses Simpan Order ke Database
    // Perhatikan: Menggunakan StoreOrderRequest, bukan Request biasa
    public function store(StoreOrderRequest $request) 
    {
        // --- VALIDASI MANUAL DIHAPUS ---
        // Karena validasi sudah otomatis dijalankan oleh StoreOrderRequest.
        // Jika data tidak valid, Laravel otomatis mengembalikan user ke halaman sebelumnya.

        // 1. Handle Upload Foto Meja
        $seatPath = null;
        if ($request->hasFile('seat_image')) {
            $seatPath = $request->file('seat_image')->store('seat_images', 'public');
        }

        // 2. Handle Upload Bukti Bayar
        $proofPath = null;
        if ($request->hasFile('payment_proof')) {
            $proofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
        }

        // 3. Hitung Total
        $cart = session()->get('cart', []);
        $total = 0;
        foreach($cart as $item) $total += $item['price'] * $item['quantity'];

        // 4. Simpan ke Database
        $order = Order::create([
            'user_id' => auth()->id(), // Ambil ID user jika login (fitur loyalitas)
            'customer_name' => $request->customer_name,
            'table_number' => $request->table_number,
            'seat_image' => $seatPath,
            'payment_proof' => $proofPath, 
            'total_price' => $total,
        ]);

        // 5. Simpan Detail Item
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'note' => $item['note'],
            ]);
        }

        // 6. Bersihkan keranjang
        session()->forget('cart');

        return redirect('/')->with('success', 'Pesanan & Pembayaran berhasil dikirim! Mohon tunggu verifikasi.');
    }
}