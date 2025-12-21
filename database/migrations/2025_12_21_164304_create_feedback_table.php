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
    Schema::create('feedback', function (Blueprint $table) {
        $table->id();
        $table->string('customer_name')->nullable(); // Boleh anonim
        $table->integer('rating'); // Skala 1-5
        $table->text('message')->nullable(); // Saran/Kritik
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
