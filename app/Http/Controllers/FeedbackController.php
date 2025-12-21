<?php

namespace App\Http\Controllers;

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
    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'required|string|max:500'
        ]);

        Feedback::create([
            'customer_name' => $request->customer_name ?? 'Anonim',
            'rating' => $request->rating,
            'message' => $request->message
        ]);

        return redirect('/')->with('success', 'Terima kasih atas masukan Anda! Kami akan terus berbenah.');
    }
}