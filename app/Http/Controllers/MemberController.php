<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    // Halaman Login Buatan (Simpel)
    public function loginForm()
    {
        return view('member.login');
    }

    public function login(Request $request)
    {
        // Login otomatis pakai User ID 1 (Pura-puranya ini akun kamu)
        // Nanti di real-app pakai email & password beneran
        $user = User::firstOrCreate(
            ['email' => 'member@kopi.com'],
            ['name' => 'Member Setia', 'password' => bcrypt('password')]
        );

        Auth::login($user);
        return redirect()->route('member.dashboard');
    }

    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('member.login');
        }

        $user = Auth::user();
        // Ambil riwayat order user ini
        $history = $user->orders()->where('status', 'completed')->latest()->get();

        return view('member.dashboard', compact('user', 'history'));
    }
}