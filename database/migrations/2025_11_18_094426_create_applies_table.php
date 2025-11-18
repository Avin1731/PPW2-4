<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applies', function (Blueprint $table) {
            $table->id();
            // Pastikan ini loker_id, bukan job_id
            // constrained('lokers') artinya nyambung ke tabel lokers
            $table->foreignId('loker_id')->constrained('lokers')->onDelete('cascade'); 
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('cv_path');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applies');
    }
};