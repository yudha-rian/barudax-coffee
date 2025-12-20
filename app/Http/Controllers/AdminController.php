<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Menu;
use App\Models\OrderItem;

class AdminController extends Controller
{
    public function index()
    {
        // 1. Ambil Order yang statusnya 'pending' (Pesanan Masuk)
        // urutkan dari yang terlama biar yang pesan duluan dilayani duluan
        $pendingOrders = Order::with('items')->where('status', 'pending')->oldest()->get();

        // 2. Ambil Order yang statusnya 'completed' (Riwayat)
        $completedOrders = Order::with('items')->where('status', 'completed')->latest()->get();

        // 3. Hitung Statistik Sederhana
        $totalRevenue = Order::where('status', 'completed')->sum('total_price');
        $totalOrders = Order::where('status', 'completed')->count();

        // 4. Logika Statistik Kopi vs Non-Kopi (Agak tricky karena kita simpan nama, bukan ID)
        // Kita ambil semua item yang terjual dari order yang sudah selesai
        $soldItems = OrderItem::whereHas('order', function($q){
            $q->where('status', 'completed');
        })->get();

        $coffeeCount = 0;
        $nonCoffeeCount = 0;

        // Cek satu per satu item, cari kategorinya di tabel Menu
        foreach($soldItems as $item) {
            $menu = Menu::where('name', $item->menu_name)->first();
            if($menu && $menu->category == 'coffee') {
                $coffeeCount += $item->quantity;
            } elseif($menu && $menu->category == 'non-coffee') {
                $nonCoffeeCount += $item->quantity;
            }
        }

        return view('admin.dashboard', compact(
            'pendingOrders', 
            'completedOrders', 
            'totalRevenue', 
            'totalOrders',
            'coffeeCount',
            'nonCoffeeCount'
        ));
    }

    // Fungsi untuk menandai pesanan selesai
    public function completeOrder($id)
    {
        $order = Order::find($id);
        $order->status = 'completed';
        $order->save();

        return redirect()->back()->with('success', 'Pesanan selesai disajikan!');
    }
}