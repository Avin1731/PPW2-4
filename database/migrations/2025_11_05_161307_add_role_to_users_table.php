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
        Schema::table('users', function (Blueprint $table) {
            // DOKUMENTASI: Baris ini menambahkan kolom baru bernama 'role'
            // ke tabel 'users'. Nilai defaultnya adalah 'user'.
            $table->string('role')->default('user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // DOKUMENTASI: Ini akan menghapus kolom 'role'
            // jika kita perlu membatalkan (rollback) migrasi.
            $table->dropColumn('role');
        });
    }
};