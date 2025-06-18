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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date');
            $table->text('about');
            $table->unsignedBigInteger('price');
            $table->unsignedBigInteger('stock');
            $table->boolean('is_popular');
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->softDeletes(); //hnya menghapus data interface tanpa hapus di db
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
