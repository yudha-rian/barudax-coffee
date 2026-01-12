<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Izinkan user mengakses request ini.
     */
    public function authorize(): bool
    {
        return true; 
    }

    /**
     * Aturan validasi untuk Checkout Order.
     */
    public function rules(): array
    {
        return [
            'customer_name' => 'required|string|max:255',
            'table_number'  => 'required|string|max:50',
            'seat_image'    => 'nullable|image|max:2048', // Opsional, Max 2MB
            'payment_proof' => 'required|image|max:2048', // Wajib, Max 2MB
        ];
    }

    /**
     * Pesan error kustom.
     */
    public function messages(): array
    {
        return [
            'customer_name.required' => 'Nama pemesan wajib diisi ya.',
            'table_number.required'  => 'Nomor meja jangan lupa diisi.',
            'payment_proof.required' => 'Bukti pembayaran wajib diupload.',
            'payment_proof.image'    => 'File bukti bayar harus berupa gambar.',
            'payment_proof.max'      => 'Ukuran foto bukti bayar maksimal 2MB.',
        ];
    }
}