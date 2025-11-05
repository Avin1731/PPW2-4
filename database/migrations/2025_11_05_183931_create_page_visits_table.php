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
        Schema::create('page_visits', function (Blueprint $table) {
            $table->id();
            $table->string('url', 2048); // URL yang dikunjungi
            $table->string('ip_address', 45)->nullable(); // IP address pengunjung
            $table->text('user_agent')->nullable(); // Browser pengunjung
            $table->foreignId('user_id')->nullable()->constrained('users'); // ID user (jika login)
            $table->timestamps(); // Waktu kunjungan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_visits');
    }
};
