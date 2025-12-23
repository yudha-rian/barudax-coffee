<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Menu;
use App\Models\OrderItem;
use App\Models\Feedback;

class AdminController extends Controller
{
    public function index()
    {
        // 1. Pesanan Masuk (Pending)
        $pendingOrders = Order::with('items')
            ->where('status', 'pending')
            ->oldest()
            ->get();

        // 2. Riwayat Pesanan (Completed)
        $completedOrders = Order::with('items')
            ->where('status', 'completed')
            ->latest()
            ->get();

        // 3. Statistik Umum
        $totalRevenue = Order::where('status', 'completed')->sum('total_price');
        $totalOrders  = Order::where('status', 'completed')->count();

        // 4. Statistik Coffee vs Non-Coffee
        $soldItems = OrderItem::whereHas('order', function ($q) {
            $q->where('status', 'completed');
        })->get();

        $coffeeCount = 0;
        $nonCoffeeCount = 0;

        foreach ($soldItems as $item) {
            $menu = Menu::where('name', $item->menu_name)->first();

            if ($menu && $menu->category === 'coffee') {
                $coffeeCount += $item->quantity;
            } elseif ($menu && $menu->category === 'non-coffee') {
                $nonCoffeeCount += $item->quantity;
            }
        }

        // 5. Feedback pelanggan terbaru
        $feedbacks = Feedback::latest()->take(5)->get();

        // ✅ SATU RETURN SAJA
        return view('admin.dashboard', compact(
            'pendingOrders',
            'completedOrders',
            'totalRevenue',
            'totalOrders',
            'coffeeCount',
            'nonCoffeeCount',
            'feedbacks'
        ));
    }

    // Menandai pesanan selesai
    public function completeOrder($id)
    {
        $order = Order::with('user')->findOrFail($id);

        if ($order->status === 'pending') {
            $order->status = 'completed';
            $order->save();

            // Logika poin loyalitas
            if ($order->user_id) {
                $pointsEarned = floor($order->total_price / 10000);
                $order->user->increment('points', $pointsEarned);
            }
        }

        return redirect()->back()
            ->with('success', 'Pesanan selesai & poin pelanggan telah ditambahkan!');
    }
}
