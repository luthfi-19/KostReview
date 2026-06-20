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
        Schema::create('kost_images', function (Blueprint $table) {
            $table->id();
            
            // Menghubungkan foto dengan kos miliknya
            $table->foreignId('kost_id')->constrained('kosts')->onDelete('cascade');
            
            // Menyimpan lokasi/nama file foto
            $table->string('image_path');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kost_images');
    }
};
