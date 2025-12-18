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
        // Validasi input
        $request->validate([
            'customer_name' => 'required',
            'table_number' => 'required',
            'seat_image' => 'image|nullable|max:2048' // Maksimal 2MB
        ]);

        // Handle Upload Foto
        $imagePath = null;
        if ($request->hasFile('seat_image')) {
            // Simpan ke folder 'public/seat_images'
            $imagePath = $request->file('seat_image')->store('seat_images', 'public');
        }

        // Hitung ulang total untuk keamanan
        $cart = session()->get('cart', []);
        $total = 0;
        foreach($cart as $item) $total += $item['price'] * $item['quantity'];

        // Simpan Data Utama Order
        $order = Order::create([
            'customer_name' => $request->customer_name,
            'table_number' => $request->table_number,
            'seat_image' => $imagePath,
            'total_price' => $total,
        ]);

        // Simpan Rincian Item
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'note' => $item['note'],
            ]);
        }

        // Kosongkan keranjang
        session()->forget('cart');

        return redirect('/')->with('success', 'Pesanan berhasil dibuat! Mohon tunggu.');
    }
}