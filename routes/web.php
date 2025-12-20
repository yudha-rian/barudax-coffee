<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;

Route::get('/', [HomeController::class, 'index']);

// Route untuk menambah ke keranjang
Route::post('/add-to-cart/{id}', [OrderController::class, 'addToCart'])->name('add.cart');

// Route untuk halaman checkout
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');

// Route untuk memproses pesanan
Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');

// Halaman Dashboard Admin
Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

// Tombol "Selesai" untuk memindahkan pesanan ke riwayat
Route::post('/admin/order/{id}/complete', [AdminController::class, 'completeOrder'])->name('admin.order.complete');