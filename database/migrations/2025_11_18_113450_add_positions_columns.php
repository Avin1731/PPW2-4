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
        Schema::table('lokers', function (Blueprint $table) {
            // Menyimpan list posisi, misal: "Frontend, Backend, UI/UX"
            $table->text('available_positions')->nullable()->after('description');
        });

        Schema::table('applies', function (Blueprint $table) {
            // Menyimpan posisi yang dipilih user, misal: "Backend"
            $table->string('selected_position')->nullable()->after('cv_path');
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lokers', function (Blueprint $table) {
            $table->dropColumn('available_positions');
        });
        Schema::table('applies', function (Blueprint $table) {
            $table->dropColumn('selected_position');
        });
    }
};
