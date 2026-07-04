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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            // ID mahasiswa yang ngasih ulasan
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // ID kos yang diulas
            $table->foreignId('kost_id')->constrained()->onDelete('cascade');
            // Rating bintang 1 sampai 5
            $table->integer('rating');
            // Isi ulasan/komentar
            $table->text('comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
