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
        Schema::table('menus', function (Blueprint $table) {
            // Mengubah kolom 'date' agar bisa NULL (kosong)
            $table->date('date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            // Mengembalikan kolom 'date' menjadi tidak bisa NULL
            // (diperlukan jika Anda ingin melakukan rollback)
            $table->date('date')->nullable(false)->change();
        });
    }
};