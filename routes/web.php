<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\FeedbackController;

Route::get('/', [HomeController::class, 'index']);

Route::get('/member/login', [MemberController::class, 'loginForm'])->name('member.login');
Route::post('/member/login', [MemberController::class, 'login']);
Route::get('/member/dashboard', [MemberController::class, 'dashboard'])->name('member.dashboard');

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

// Route Halaman Feedback
Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');