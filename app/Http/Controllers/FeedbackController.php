<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeedbackRequest; // <--- 1. Import Form Request Baru
use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    // Tampilkan Form
    public function create()
    {
        return view('feedback.create');
    }

    // Simpan Data
    // Perhatikan: Menggunakan StoreFeedbackRequest, bukan Request biasa
    public function store(StoreFeedbackRequest $request)
    {
        // --- VALIDASI MANUAL DIHAPUS ---
        // $request->validate([...]); 
        // Bagian ini sudah tidak perlu karena Laravel otomatis menjalankan 
        // rules() yang ada di dalam StoreFeedbackRequest.php sebelum masuk ke sini.

        // Langsung simpan ke database
        Feedback::create([
            'customer_name' => $request->customer_name ?? 'Anonim',
            'rating'        => $request->rating,
            'message'       => $request->message
        ]);

        return redirect('/')->with('success', 'Terima kasih atas masukan Anda! Kami akan terus berbenah.');
    }
}