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
        Schema::create('kost_facility', function (Blueprint $table) {
            $table->id();
            
            // Jembatan ke tabel kosts
            $table->foreignId('kost_id')->constrained('kosts')->onDelete('cascade');
            
            // Jembatan ke tabel facilities
            $table->foreignId('facility_id')->constrained('facilities')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kost_facility');
    }
};
