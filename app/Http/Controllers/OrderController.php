<?php

namespace App\Http\Controllers;

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
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'customer_name' => 'required',
            'table_number' => 'required',
            'seat_image' => 'image|nullable|max:2048',
            'payment_proof' => 'required|image|max:2048' // Wajib upload bukti
        ]);

        // 2. Handle Upload Foto Meja
        $seatPath = null;
        if ($request->hasFile('seat_image')) {
            $seatPath = $request->file('seat_image')->store('seat_images', 'public');
        }

        // 3. Handle Upload Bukti Bayar (BARU)
        $proofPath = null;
        if ($request->hasFile('payment_proof')) {
            $proofPath = $request->file('payment_proof')->store('payment_proofs', 'public');
        }

        // 4. Hitung Total
        $cart = session()->get('cart', []);
        $total = 0;
        foreach($cart as $item) $total += $item['price'] * $item['quantity'];

        // 5. Simpan ke Database
        $order = Order::create([
            'user_id' => auth()->id(), //Ambil ID user jika sedang login, jika tidak null
            'customer_name' => $request->customer_name,
            'table_number' => $request->table_number,
            'seat_image' => $seatPath,
            'payment_proof' => $proofPath, // Simpan path bukti
            'total_price' => $total,
        ]);

        // 6. Simpan Detail Item
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'note' => $item['note'],
            ]);
        }

        // 7. Bersihkan keranjang
        session()->forget('cart');

        return redirect('/')->with('success', 'Pesanan & Pembayaran berhasil dikirim! Mohon tunggu verifikasi.');
    }
}