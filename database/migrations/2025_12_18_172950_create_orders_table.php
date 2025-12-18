<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('customer_name');    // Nama Pelanggan
        $table->string('table_number');     // Lokasi Duduk
        $table->string('seat_image')->nullable(); // Foto Lokasi (Opsional)
        $table->integer('total_price');     // Total Bayar
        $table->enum('status', ['pending', 'completed'])->default('pending');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
